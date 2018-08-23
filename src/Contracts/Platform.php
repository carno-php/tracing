<?php
/**
 * Platform API
 * User: moyo
 * Date: 24/11/2017
 * Time: 11:33 AM
 */

namespace Carno\Tracing\Contracts;

use Carno\Promise\Promised;

interface Platform
{
    /**
     * @return Env
     */
    public function env() : Env;

    /**
     * @return bool
     */
    public function joined() : bool;

    /**
     * @return Promised
     */
    public function leave() : Promised;

    /**
     * @return Carrier
     */
    public function carrier() : Carrier;

    /**
     * @return Protocol
     */
    public function serializer() : Protocol;

    /**
     * @return Transport
     */
    public function transporter() : Transport;
}
