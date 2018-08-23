<?php
/**
 * Endpoint for local/remote
 * User: moyo
 * Date: 24/11/2017
 * Time: 3:51 PM
 */

namespace Carno\Tracing\Standard;

use Carno\Net\Address;

class Endpoint
{
    /**
     * @var string
     */
    private $service = null;

    /**
     * @var Address
     */
    private $address = null;

    /**
     * Endpoint constructor.
     * @param string $service
     * @param Address $address
     */
    public function __construct(string $service, Address $address = null)
    {
        $this->service = $service;
        $this->address = $address ?? new Address(0);
    }

    /**
     * @return string
     */
    public function service() : string
    {
        return $this->service;
    }

    /**
     * @return string
     */
    public function ipv4() : string
    {
        return $this->address->host();
    }

    /**
     * @return int
     */
    public function port() : int
    {
        return $this->address->port();
    }
}
