<?php
/**
 * Timestamp generator
 * User: moyo
 * Date: 24/11/2017
 * Time: 11:01 AM
 */

namespace Carno\Tracing\Chips;

trait Timestamp
{
    /**
     * @return int
     */
    protected function microseconds() : int
    {
        return microtime(true) * 1000000;
    }
}
