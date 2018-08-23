<?php
/**
 * Context generator for carrier
 * User: moyo
 * Date: 23/11/2017
 * Time: 4:47 PM
 */

namespace Carno\Tracing\Chips;

use Carno\Tracing\Contracts\Vars\CTX;
use Carno\Tracing\Standard\Context;
use OpenTracing\Exceptions\SpanContextNotFound;

trait ContextOperator
{
    use IDGenerator;

    /**
     * @param Context|null $in
     * @return Context
     */
    public function fusedContext(Context $in = null) : Context
    {
        return $in ? $this->initFromContext($in) : $this->toNewContext();
    }

    /**
     * @return Context
     */
    protected function toNewContext() : Context
    {
        if (empty($traceID = $this->getTraceID())) {
            throw SpanContextNotFound::create();
        }

        $overrides = [
            CTX::TRACE_ID => $traceID,
            CTX::SPAN_ID => $this->newSpanID(),
            CTX::PARENT_SPAN_ID => $this->getSpanID(),
            CTX::TRACE_SAMPLED => $this->checkIsSampled(),
        ];

        return new Context(array_merge($this->getBaggageItems(), $overrides));
    }

    /**
     * @param Context $ctx
     * @return Context
     */
    protected function initFromContext(Context $ctx) : Context
    {
        $this->setTraceID($ctx[CTX::TRACE_ID] ?? '');
        $this->setSpanID($ctx[CTX::SPAN_ID] ?? '');

        if ($ctx[CTX::PARENT_SPAN_ID] ?? '') {
            $this->setParentSpanID($ctx[CTX::PARENT_SPAN_ID]);
        }

        $this->markIsSampled($ctx[CTX::TRACE_SAMPLED] ?? false);

        $items = [];

        foreach ($ctx->getIterator() as $k => $v) {
            if (in_array($k, [CTX::TRACE_ID, CTX::SPAN_ID, CTX::PARENT_SPAN_ID, CTX::TRACE_SAMPLED])) {
                continue;
            } else {
                $items[$k] = $v;
            }
        }

        $items && $this->setBaggageItems($items);

        return $ctx;
    }
}
