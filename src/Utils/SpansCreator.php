<?php
/**
 * Spans creator
 * User: moyo
 * Date: 19/12/2017
 * Time: 4:52 PM
 */

namespace Carno\Tracing\Utils;

use Carno\Container\DI;
use Carno\Coroutine\Context;
use Carno\Promise\Promised;
use Carno\Tracing\Chips\Timestamp;
use Carno\Tracing\Contracts\Platform;
use Carno\Tracing\Contracts\Vars\CTX;
use Carno\Tracing\Contracts\Vars\FMT;
use Carno\Tracing\Contracts\Vars\LOG;
use Carno\Tracing\Contracts\Vars\TAG;
use Carno\Tracing\Standard\Span;
use Carno\Tracing\Standard\Tracer;
use OpenTracing\Exceptions\SpanContextNotFound;
use OpenTracing\SpanContext;
use OpenTracing\SpanOptions;
use Throwable;

trait SpansCreator
{
    use Timestamp;

    /**
     * @return bool
     */
    protected function traced() : bool
    {
        /**
         * @var Platform $platform
         */

        if (DI::has(Platform::class) && $platform = DI::get(Platform::class)) {
            return $platform->joined();
        }

        return false;
    }

    /**
     * @param Context $context
     * @param string $name
     * @param array $tags
     * @param array $log
     * @param string $exaFormat
     * @param mixed $exaCarrier
     * @param SpanContext $exaContext
     * @param Platform $platform
     */
    protected function newSpan(
        Context $context,
        string $name,
        array $tags = [],
        array $log = [],
        string $exaFormat = null,
        $exaCarrier = null,
        SpanContext $exaContext = null,
        Platform $platform = null
    ) : void {
        if (is_null($platform)) {
            if (DI::has(Platform::class)) {
                $platform = DI::get(Platform::class);
            } else {
                // missing platform support
                return;
            }
        }

        // check platform is ready
        if (!$platform->joined()) {
            return;
        }

        // get/set tracer
        if ($context->has(CTX::G_TRACER)) {
            $tracer = $context->get(CTX::G_TRACER);
        } else {
            $context->set(CTX::G_TRACER, $tracer = new Tracer($platform));
        }

        // options
        $options = [
            'start_time' => $this->microseconds(),
            'tags' => array_merge($platform->env()->tags(), $tags),
        ];

        // inherit from root
        if (is_null($exaFormat) && $context->has(CTX::G_ROOT)) {
            $exaFormat = FMT::PREV_CTX;
            $exaCarrier = $context->get(CTX::G_ROOT);
        }

        // extracting
        if ($exaFormat) {
            try {
                // check reference
                if ($exaContext) {
                    $tracer->inject($exaContext, $exaFormat, $exaCarrier);
                    $options['child_of'] = $exaContext;
                } else {
                    $options['child_of'] = $tracer->extract($exaFormat, $exaCarrier);
                }
            } catch (SpanContextNotFound $e) {
                // root span
            }
        }

        // is root
        $root = ! $context->has(CTX::G_SPAN);

        // new span
        $context->set(CTX::G_SPAN, $span = $tracer->startSpan($name, SpanOptions::create($options)));

        // root ctx
        $root && $context->set(CTX::G_ROOT, $span->getContext());

        // some log
        $span->log($log);
    }

    /**
     * @param Promised $finished
     * @param Context $traced
     * @return Promised
     */
    protected function finishSpan(Promised $finished, Context $traced = null) : Promised
    {
        $traced && $finished->then(function () use ($traced) {
            $this->closeSpan($traced);
        }, function (Throwable $e) use ($traced) {
            $this->errorSpan($traced, $e);
        });
        return $finished;
    }

    /**
     * @param Context $context
     * @param array $tags
     */
    protected function closeSpan(Context $context, array $tags = []) : void
    {
        if ($context->has(CTX::G_SPAN)) {
            /**
             * @var Span $span
             */
            $span = $context->get(CTX::G_SPAN);
            $span->setTags($tags);
            $span->finish();
            $this->endingSpan($context);
        }
    }

    /**
     * @param Context $context
     * @param Throwable $err
     * @param array $tags
     */
    protected function errorSpan(Context $context, Throwable $err = null, array $tags = []) : void
    {
        if ($context->has(CTX::G_SPAN)) {
            /**
             * @var Span $span
             */
            $span = $context->get(CTX::G_SPAN);
            $span->setTags(array_merge([TAG::ERROR => true], $tags));
            $span->log([
                LOG::EVENT => TAG::ERROR,
                LOG::ERROR_KIND => get_class($err),
                LOG::ERROR_OBJECT => $err,
                LOG::MESSAGE => $err->getMessage(),
                LOG::STACK => $err->getTraceAsString(),
            ]);
            $span->finish();
            $this->endingSpan($context);
        }
    }

    /**
     * @param Context $context
     */
    private function endingSpan(Context $context) : void
    {
        if ($context->has(CTX::G_TRACER)) {
            /**
             * @var Tracer $tracer
             */
            $tracer = $context->get(CTX::G_TRACER);
            $tracer->flush();
        }
    }
}
