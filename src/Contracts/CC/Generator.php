<?php
/**
 * Context generator
 * User: moyo
 * Date: 23/11/2017
 * Time: 4:40 PM
 */

namespace Carno\Tracing\Contracts\CC;

use Carno\Tracing\Standard\Context;

interface Generator
{
    /**
     * @param Context $in
     * @return Context
     */
    public function fusedContext(Context $in = null) : Context;
}
