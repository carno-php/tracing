<?php
/**
 * Platform swap
 * User: moyo
 * Date: Jul 03, 2019
 * Time: 11:31
 */

namespace Carno\Tracing\Tests\Mocked;

use Carno\Net\Address;
use Carno\Promise\Promise;
use Carno\Promise\Promised;
use Carno\Tracing\Contracts\Carrier;
use Carno\Tracing\Contracts\Env;
use Carno\Tracing\Contracts\Platform;
use Carno\Tracing\Contracts\Protocol;
use Carno\Tracing\Contracts\Transport;
use Carno\Tracing\Standard\Span;

class PlatformSwap implements Platform
{
    private $transporter = null;

    public function env() : Env
    {
        return new class implements Env {
            public function tags() : array
            {
                return ['local' => 'swap'];
            }
        };
    }

    public function init() : Promised
    {
        return Promise::resolved();
    }

    public function joined() : bool
    {
        return true;
    }

    public function leave() : Promised
    {
        return Promise::resolved();
    }

    public function carrier() : Carrier
    {
        return null;
    }

    public function serializer() : Protocol
    {
        return new class implements Protocol {
            public function serialize(Span $span) : string
            {
                return json_encode([
                    'op' => $span->getOperationName(),
                    'ctx' => $span->getContext(),
                    'tags' => $span->getTags(),
                    'logs' => $span->getLogs(),
                ]);
            }
        };
    }

    public function transporter() : Transport
    {
        if ($this->transporter) {
            return $this->transporter;
        }

        return $this->transporter = new class implements Transport {
            private $data = [];

            public function connect(Address $endpoint, string $identify = null) : void
            {
            }

            public function disconnect() : Promised
            {
                return Promise::resolved();
            }

            public function loading(string $data) : void
            {
                $this->data[] = $data;
            }

            public function flushing() : void
            {
            }

            public function data() : array
            {
                return $this->data;
            }
        };
    }
}
