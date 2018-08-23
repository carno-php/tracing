<?php
/**
 * Spans exporter
 * User: moyo
 * Date: 16/01/2018
 * Time: 11:39 AM
 */

namespace Carno\Tracing\Utils;

use Carno\Coroutine\Context;
use Carno\HTTP\Standard\Message;
use Carno\Tracing\Contracts\Vars\CTX;
use Carno\Tracing\Contracts\Vars\FMT;
use Carno\Tracing\Standard\Span;
use Carno\Tracing\Standard\Tracer;

trait SpansExporter
{
    /**
     * @param Context $ctx
     * @param Message $http
     */
    protected function spanToHResponse(Context $ctx, Message $http) : void
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
