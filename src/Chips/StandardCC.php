<?php
/**
 * Use standard context carrier
 * User: moyo
 * Date: 27/12/2017
 * Time: 11:44 AM
 */

namespace Carno\Tracing\Chips;

use Carno\Tracing\Contracts\Carrier;
use Carno\Tracing\Standard\Carriers\Context;
use Carno\Tracing\Standard\Context as OpenContext;

trait StandardCC
{
    use ContextOperator;

    /**
     * @param OpenContext $context
     * @return Carrier
     */
    public function ctx(OpenContext $context) : Carrier
    {
        return new Context($context);
    }
}
