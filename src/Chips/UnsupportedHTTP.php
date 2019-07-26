<?php
/**
 * Unsupported http carrier
 * User: moyo
 * Date: 27/12/2017
 * Time: 11:45 AM
 */

namespace Carno\Tracing\Chips;

use Carno\Tracing\Contracts\Carrier;
use Carno\Tracing\Exception\UnsupportedCarrierException;
use Psr\Http\Message\MessageInterface;

trait UnsupportedHTTP
{
    public function http(MessageInterface $message) : Carrier
    {
        throw new UnsupportedCarrierException('HTTP in ' . get_class($this));
    }
}
