<?php
/**
 * Environment
 * User: moyo
 * Date: 2018/7/23
 * Time: 10:38 AM
 */

namespace Carno\Tracing\Contracts;

interface Env
{
    /**
     * @return array
     */
    public function tags() : array;
}
