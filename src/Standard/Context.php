<?php
/**
 * OpenTracing::Context
 * User: moyo
 * Date: 23/11/2017
 * Time: 3:31 PM
 */

namespace Carno\Tracing\Standard;

use OpenTracing\SpanContext;
use ArrayIterator;
use ArrayObject;

class Context extends ArrayObject implements SpanContext
{
    /**
     * @return ArrayIterator
     */
    public function getIterator() : ArrayIterator
    {
        return new ArrayIterator($this->getArrayCopy());
    }

    /**
     * @param string $key
     * @return string|null
     */
    public function getBaggageItem($key) : ?string
    {
        return $this->offsetExists($key) ? $this->offsetGet($key) : null;
    }

    /**
     * @param string $key
     * @param string $value
     * @return SpanContext
     */
    public function withBaggageItem($key, $value) : SpanContext
    {
        $new = clone $this;
        $new->offsetSet($key, $value);
        return $new;
    }
}
