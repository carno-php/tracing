<?php
/**
 * Standard HTTP carrier (zipkin styles)
 * User: moyo
 * Date: 24/11/2017
 * Time: 11:37 AM
 */

namespace Carno\Tracing\Standard\Carriers;

use Carno\HTTP\Standard\Helper;
use Carno\HTTP\Standard\Message;
use Carno\Tracing\Chips\StandardCC;
use Carno\Tracing\Contracts\Carrier;

class HTTP implements Carrier
{
    use Helper;
    use StandardCC;

    /**
     * prefixes
     */
    private const STATE_PREFIX = 'x-b3-';
    private const BAGGAGE_PREFIX = 'ot-baggage-';

    /**
     * extend vars
     */
    private const EXT_TRACE_ID = 'traceid';
    private const EXT_SPAN_ID = 'spanid';
    private const EXT_PARENT_SPAN_ID = 'parentspanid';
    private const EXT_SAMPLED = 'sampled';

    /**
     * @var Message
     */
    private $message = null;

    /**
     * HTTP constructor.
     * @param Message $message
     */
    public function __construct(Message $message = null)
    {
        $this->message = $message;
    }

    /**
     * @param Message $message
     * @return Carrier
     */
    public function http(Message $message) : Carrier
    {
        return new static($message);
    }

    /**
     * @return string
     */
    public function getTraceID() : string
    {
        return $this->message->getHeaderLine($this->getStateKey(self::EXT_TRACE_ID));
    }

    /**
     * @param string $id
     */
    public function setTraceID(string $id) : void
    {
        $this->message->withHeader($this->getStateKey(self::EXT_TRACE_ID), $id);
    }

    /**
     * @return string
     */
    public function getSpanID() : string
    {
        return $this->message->getHeaderLine($this->getStateKey(self::EXT_SPAN_ID));
    }

    /**
     * @param string $id
     */
    public function setSpanID(string $id) : void
    {
        $this->message->withHeader($this->getStateKey(self::EXT_SPAN_ID), $id);
    }

    /**
     * @return string
     */
    public function getParentSpanID() : string
    {
        return $this->message->getHeaderLine($this->getStateKey(self::EXT_PARENT_SPAN_ID));
    }

    /**
     * @param string $id
     */
    public function setParentSpanID(string $id) : void
    {
        $this->message->withHeader($this->getStateKey(self::EXT_PARENT_SPAN_ID), $id);
    }

    /**
     * @return array
     */
    public function getBaggageItems() : array
    {
        $items = [];
        foreach ($this->getHeaderLines($this->message) as $name => $value) {
            if (substr($name, 0, strlen(self::BAGGAGE_PREFIX)) === self::BAGGAGE_PREFIX) {
                $items[substr($name, strlen(self::BAGGAGE_PREFIX))] = $value;
            }
        }
        return $items;
    }

    /**
     * @param array $items
     */
    public function setBaggageItems(array $items) : void
    {
        foreach ($items as $name => $value) {
            if (is_scalar($value)) {
                $this->message->withHeader(sprintf('%s%s', self::BAGGAGE_PREFIX, $name), $value);
            }
        }
    }

    /**
     * @return bool
     */
    public function checkIsSampled() : bool
    {
        return $this->message->getHeaderLine($this->getStateKey(self::EXT_SAMPLED)) === '1';
    }

    /**
     * @param bool $sampled
     */
    public function markIsSampled(bool $sampled) : void
    {
        $this->message->withHeader($this->getStateKey(self::EXT_SAMPLED), $sampled ? 1 : 0);
    }

    /**
     * @param string $ext
     * @return string
     */
    private function getStateKey(string $ext) : string
    {
        return sprintf('%s%s', self::STATE_PREFIX, $ext);
    }
}
