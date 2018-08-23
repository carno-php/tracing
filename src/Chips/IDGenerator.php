<?php
/**
 * Identify generator
 * User: moyo
 * Date: 24/11/2017
 * Time: 2:22 PM
 */

namespace Carno\Tracing\Chips;

trait IDGenerator
{
    /**
     * @param int $bits
     * @return string
     */
    protected function newID(int $bits) : string
    {
        return bin2hex(random_bytes($bits / 8));
    }

    /**
     * @return string
     */
    protected function newTraceID() : string
    {
        return bin2hex(random_bytes(16));
    }

    /**
     * @return string
     */
    protected function newSpanID() : string
    {
        return bin2hex(random_bytes(8));
    }
}
