<?php
/**
 * Spans linker
 * User: moyo
 * Date: 01/03/2018
 * Time: 3:19 PM
 */

namespace Carno\Tracing\Utils;

use Carno\Coroutine\Context;
use Carno\Tracing\Chips\RootInitializer;
use Carno\Tracing\Contracts\Vars\CTX;
use OpenTracing\SpanContext;

trait SpansLinker
{
    use RootInitializer;

    /**
     * @param Context $context
     * @return SpanContext
     */
    protected function rootCTX(Context $context) : ?SpanContext
    {
        return $context->get(CTX::G_ROOT) ?: null;
    }

    /**
     * @param SpanContext $parent
     * @return SpanContext
     */
    private function linkedCTX(SpanContext $parent = null) : SpanContext
    {
        return
            $parent
                ? $parent
                    ->withBaggageItem(CTX::PARENT_SPAN_ID, $parent->getBaggageItem(CTX::SPAN_ID))
                    ->withBaggageItem(CTX::SPAN_ID, $this->newSpanID())
                : $this->newContext()
        ;
    }
}
