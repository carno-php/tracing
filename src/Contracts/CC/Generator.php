<?php
/**
 * Context generator
 * User: moyo
 * Date: 23/11/2017
 * Time: 4:40 PM
 */

namespace Carno\Tracing\Contracts\CC;

use OpenTracing\SpanContext;

interface Generator
{
    /**
     * @param SpanContext $in
     * @return SpanContext
     */
    public function fusedContext(SpanContext $in = null) : SpanContext;
}
