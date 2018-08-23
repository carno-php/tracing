<?php
/**
 * Unsupported http carrier
 * User: moyo
 * Date: 27/12/2017
 * Time: 11:45 AM
 */

namespace Carno\Tracing\Chips;

use Carno\HTTP\Standard\Message;
use Carno\Tracing\Contracts\Carrier;
use Carno\Tracing\Exception\UnsupportedCarrierException;

trait UnsupportedHTTP
{
    public function http(Message $message) : Carrier
    {
        throw new UnsupportedCarrierException('HTTP in '.get_class($this));
    }
}
