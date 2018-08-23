<?php
/**
 * Context injector
 * User: moyo
 * Date: 23/11/2017
 * Time: 4:37 PM
 */

namespace Carno\Tracing\Contracts\CC;

interface Injector
{
    /**
     * @param string $id
     */
    public function setTraceID(string $id) : void;

    /**
     * @param string $id
     */
    public function setSpanID(string $id) : void;

    /**
     * @param string $id
     */
    public function setParentSpanID(string $id) : void;

    /**
     * @param array $items
     */
    public function setBaggageItems(array $items) : void;

    /**
     * @param bool $sampled
     */
    public function markIsSampled(bool $sampled) : void;
}
