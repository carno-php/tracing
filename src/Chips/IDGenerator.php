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
     * @return string
     */
    protected function newTraceID() : string
    {
        return bin2hex(random_bytes(defined('TRACING_ID_128BIT') ? 16 : 8));
    }

    /**
     * @return string
     */
    protected function newSpanID() : string
    {
        return bin2hex(random_bytes(8));
    }
}
