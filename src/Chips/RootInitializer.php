<?php
/**
 * Root span initializer
 * User: moyo
 * Date: 23/11/2017
 * Time: 6:11 PM
 */

namespace Carno\Tracing\Chips;

use Carno\Tracing\Contracts\Vars\CTX;
use Carno\Tracing\Standard\Context;

trait RootInitializer
{
    use IDGenerator;

    /**
     * @return Context
     */
    private function newContext() : Context
    {
        return new Context([
            CTX::TRACE_ID => $this->newTraceID(),
            CTX::SPAN_ID => $this->newSpanID(),
            CTX::TRACE_SAMPLED => true,
        ]);
    }
}
