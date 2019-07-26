<?php
/**
 * OpenTracing::Tracer
 * User: moyo
 * Date: 23/11/2017
 * Time: 10:38 AM
 */

namespace Carno\Tracing\Standard;

use Carno\Tracing\Chips\RootInitializer;
use Carno\Tracing\Contracts\Platform;
use Carno\Tracing\Contracts\Vars\FMT;
use Carno\Tracing\Exception\UnsupportedCarrierInstance;
use OpenTracing\Exceptions\SpanContextNotFound;
use OpenTracing\Exceptions\UnsupportedFormat;
use OpenTracing\Span as OpenSpan;
use OpenTracing\SpanContext;
use OpenTracing\SpanOptions;
use OpenTracing\Tracer as TracerAPI;
use Psr\Http\Message\MessageInterface;

class Tracer implements TracerAPI
{
    use RootInitializer;

    /**
     * @var Platform
     */
    private $platform = null;

    /**
     * Tracer constructor.
     * @param Platform $platform
     */
    public function __construct(Platform $platform)
    {
        $this->platform = $platform;
    }

    /**
     * @param string $operationName
     * @param SpanOptions $options
     * @return OpenSpan
     */
    public function startSpan($operationName, $options = null) : OpenSpan
    {
        $context = null;
        $startTime = null;

        if ($options) {
            $startTime = $options->getStartTime();
            $references = $options->getReferences();
            if ($references) {
                $context = (reset($references))->getContext();
            }
        }

        $span = new Span(
            $this->platform->serializer(),
            $this->platform->transporter(),
            $context ?? $this->newContext(),
            $startTime
        );

        $span->overwriteOperationName($operationName);

        if ($options) {
            $span->setTags($options->getTags());
        }

        return $span;
    }

    /**
     * @param SpanContext $spanContext
     * @param string $format
     * @param mixed $carrier
     */
    public function inject(SpanContext $spanContext, $format, &$carrier) : void
    {
        switch ($format) {
            case FMT::HTTP_HEADERS:
                if ($carrier instanceof MessageInterface) {
                    $this->platform->carrier()->http($carrier)->fusedContext($spanContext);
                } else {
                    throw UnsupportedCarrierInstance::for(gettype($carrier));
                }
                break;
            default:
                throw UnsupportedFormat::forFormat($format);
        }
    }

    /**
     * @param string $format
     * @param mixed $carrier
     * @return SpanContext
     */
    public function extract($format, $carrier) : SpanContext
    {
        switch ($format) {
            case FMT::PREV_CTX:
                return $this->platform->carrier()->ctx($carrier)->fusedContext();
            case FMT::HTTP_HEADERS:
                if ($carrier instanceof MessageInterface) {
                    return $this->platform->carrier()->http($carrier)->fusedContext();
                }
                throw SpanContextNotFound::create();
            default:
                throw UnsupportedFormat::forFormat($format);
        }
    }

    /**
     * flush to some collector
     */
    public function flush() : void
    {
        $this->platform->transporter()->flushing();
    }
}
