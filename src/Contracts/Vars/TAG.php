<?php
/**
 * TAG related constants (overall)
 * User: moyo
 * Date: 2018/7/23
 * Time: 11:58 AM
 */

namespace Carno\Tracing\Contracts\Vars;

interface TAG
{
    /**
     * @see \OpenTracing\Ext\Tags\
     */

    public const SPAN_KIND = 'span.kind';
    public const SPAN_KIND_RPC_CLIENT = 'client';
    public const SPAN_KIND_RPC_SERVER = 'server';
    public const SPAN_KIND_MESSAGE_BUS_PRODUCER = 'producer';
    public const SPAN_KIND_MESSAGE_BUS_CONSUMER = 'consumer';
    public const COMPONENT = 'component';
    public const SAMPLING_PRIORITY = 'sampling.priority';
    public const PEER_SERVICE = 'peer.service';
    public const PEER_HOSTNAME = 'peer.hostname';
    public const PEER_ADDRESS = 'peer.address';
    public const PEER_HOST_IPV4 = 'peer.ipv4';
    public const PEER_HOST_IPV6 = 'peer.ipv6';
    public const PEER_PORT = 'peer.port';
    public const HTTP_URL = 'http.url';
    public const HTTP_METHOD = 'http.method';
    public const HTTP_STATUS_CODE = 'http.status_code';
    public const DATABASE_INSTANCE = 'db.instance';
    public const DATABASE_STATEMENT = 'db.statement';
    public const DATABASE_TYPE = 'db.type';
    public const DATABASE_USER = 'db.user';
    public const MESSAGE_BUS_DESTINATION = 'message_bus.destination';
    public const ERROR = 'error';

    /**
     * extends
     */

    public const HOSTNAME = 'hostname';
    public const LANG_EXE = 'lang.exec';
    public const ENV_TAGS = 'tags.env';
    public const ROUTE_TAGS = 'tags.route';
    public const USER_AGENT = 'user.agent';
    public const CONTENT_TYPE = 'content.type';
}
