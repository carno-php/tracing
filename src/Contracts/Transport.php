<?php
/**
 * Transporter API
 * User: moyo
 * Date: 24/11/2017
 * Time: 11:23 AM
 */

namespace Carno\Tracing\Contracts;

use Carno\Net\Address;
use Carno\Promise\Promised;

interface Transport
{
    /**
     * @param Address $endpoint
     * @param string $identify
     */
    public function connect(Address $endpoint, string $identify = null) : void;

    /**
     * @return Promised
     */
    public function disconnect() : Promised;

    /**
     * maybe just to buffer
     * @param string $data
     */
    public function loading(string $data) : void;

    /**
     * must flush to collector
     */
    public function flushing() : void;
}
