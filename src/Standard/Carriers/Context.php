<?php
/**
 * Standard context carrier
 * User: moyo
 * Date: 27/12/2017
 * Time: 11:39 AM
 */

namespace Carno\Tracing\Standard\Carriers;

use Carno\Tracing\Chips\StandardCC;
use Carno\Tracing\Chips\UnsupportedHTTP;
use Carno\Tracing\Contracts\Carrier;
use Carno\Tracing\Contracts\Vars\CTX;
use Carno\Tracing\Standard\Context as OpenContext;

class Context implements Carrier
{
    use StandardCC, UnsupportedHTTP;

    /**
     * @var OpenContext
     */
    private $ctx = null;

    /**
     * Context constructor.
     * @param OpenContext $context
     */
    public function __construct(OpenContext $context)
    {
        $this->ctx = $context;
    }

    /**
     * @return string|int
     */
    public function getTraceID()
    {
        return $this->ctx[CTX::TRACE_ID] ?? '';
    }

    /**
     * @return string|int
     */
    public function getSpanID()
    {
        return $this->ctx[CTX::SPAN_ID] ?? '';
    }

    /**
     * @return string|int
     */
    public function getParentSpanID()
    {
        return $this->ctx[CTX::PARENT_SPAN_ID] ?? '';
    }

    /**
     * @return array
     */
    public function getBaggageItems() : array
    {
        return (array) $this->ctx;
    }

    /**
     * @return bool
     */
    public function checkIsSampled() : bool
    {
        return $this->ctx[CTX::TRACE_SAMPLED] ?? false;
    }

    /**
     * @param string $id
     */
    public function setTraceID(string $id) : void
    {
        $this->ctx[CTX::TRACE_ID] = $id;
    }

    /**
     * @param string $id
     */
    public function setSpanID(string $id) : void
    {
        $this->ctx[CTX::SPAN_ID] = $id;
    }

    /**
     * @param string $id
     */
    public function setParentSpanID(string $id) : void
    {
        $this->ctx[CTX::PARENT_SPAN_ID] = $id;
    }

    /**
     * @param array $items
     */
    public function setBaggageItems(array $items) : void
    {
        foreach ($items as $key => $val) {
            $this->ctx[$key] = $val;
        }
    }

    /**
     * @param bool $sampled
     */
    public function markIsSampled(bool $sampled) : void
    {
        $this->ctx[CTX::TRACE_SAMPLED] = $sampled;
    }
}
