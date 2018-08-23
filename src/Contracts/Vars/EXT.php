<?php
/**
 * EXT related constants
 * User: moyo
 * Date: 2018/7/23
 * Time: 11:48 AM
 */

namespace Carno\Tracing\Contracts\Vars;

interface EXT
{
    /**
     * extend context keys for internal using
     */
    public const LOCAL_ENDPOINT = 'endpoint.local';
    public const REMOTE_ENDPOINT = 'endpoint.remote';
}
