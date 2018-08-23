<?php
/**
 * Protocol serialize
 * User: moyo
 * Date: 24/11/2017
 * Time: 11:21 AM
 */

namespace Carno\Tracing\Contracts;

use Carno\Tracing\Standard\Span;

interface Protocol
{
    /**
     * @param Span $span
     * @return string
     */
    public function serialize(Span $span) : string;
}
