<?php
/**
 * Related endpoints
 * User: moyo
 * Date: 24/11/2017
 * Time: 4:01 PM
 */

namespace Carno\Tracing\Chips;

use Carno\Tracing\Standard\Endpoint;

trait RelatedEndpoints
{
    /**
     * @var Endpoint
     */
    private $localEP = null;

    /**
     * @var Endpoint
     */
    private $remoteEP = null;

    /**
     * @param Endpoint $endpoint
     */
    public function setLocalEndpoint(Endpoint $endpoint) : void
    {
        $this->localEP = $endpoint;
    }

    /**
     * @return Endpoint
     */
    public function getLocalEndpoint() : ?Endpoint
    {
        return $this->localEP;
    }

    /**
     * @param Endpoint $endpoint
     */
    public function setRemoteEndpoint(Endpoint $endpoint) : void
    {
        $this->remoteEP = $endpoint;
    }

    /**
     * @return Endpoint
     */
    public function getRemoteEndpoint() : ?Endpoint
    {
        return $this->remoteEP;
    }
}
