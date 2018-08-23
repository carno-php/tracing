<?php
/**
 * Context extractor
 * User: moyo
 * Date: 23/11/2017
 * Time: 4:23 PM
 */

namespace Carno\Tracing\Contracts\CC;

interface Extractor
{
    /**
     * @return string|int
     */
    public function getTraceID();

    /**
     * @return string|int
     */
    public function getSpanID();

    /**
     * @return string|int
     */
    public function getParentSpanID();

    /**
     * @return array
     */
    public function getBaggageItems() : array;

    /**
     * @return bool
     */
    public function checkIsSampled() : bool;
}
