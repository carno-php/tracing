<?php
/**
 * Spans exporter
 * User: moyo
 * Date: 16/01/2018
 * Time: 11:39 AM
 */

namespace Carno\Tracing\Utils;

use Carno\Coroutine\Context;
use Carno\Tracing\Contracts\Vars\CTX;
use Carno\Tracing\Contracts\Vars\FMT;
use Carno\Tracing\Standard\Span;
use Carno\Tracing\Standard\Tracer;
use Psr\Http\Message\MessageInterface;

trait SpansExporter
{
    /**
     * @param Context $ctx
     * @param MessageInterface $http
     */
    protected function spanToHResponse(Context $ctx, MessageInterface $http) : void
    {
        if ($ctx->has(CTX::G_TRACER) && $ctx->has(CTX::G_SPAN)) {
            /**
             * @var Tracer $tracer
             * @var Span $span
             */
            $tracer = $ctx->get(CTX::G_TRACER);
            $span = $ctx->get(CTX::G_SPAN);

            $tracer->inject($span->getContext(), FMT::HTTP_HEADERS, $http);
        }
    }
}
