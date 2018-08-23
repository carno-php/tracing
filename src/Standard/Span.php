<?php
/**
 * OpenTracing::Span
 * User: moyo
 * Date: 23/11/2017
 * Time: 3:28 PM
 */

namespace Carno\Tracing\Standard;

use Carno\Tracing\Chips\RelatedEndpoints;
use Carno\Tracing\Chips\SpanInfoGetter;
use Carno\Tracing\Chips\Timestamp;
use Carno\Tracing\Contracts\Protocol;
use Carno\Tracing\Contracts\Transport;
use OpenTracing\Span as SpanAPI;
use OpenTracing\SpanContext;

class Span implements SpanAPI
{
    use Timestamp;
    use SpanInfoGetter, RelatedEndpoints;

    /**
     * operate not permit
     */
    private const E_FINISHED = 'This span is already finished';

    /**
     * @var string
     */
    private $operation = null;

    /**
     * @var Protocol
     */
    private $serializer = null;

    /**
     * @var Transport
     */
    private $transporter = null;

    /**
     * @var Context
     */
    private $context = null;

    /**
     * @var int
     */
    private $startAt = null;

    /**
     * @var int
     */
    private $endAt = null;

    /**
     * @var bool
     */
    private $finished = false;

    /**
     * @var array
     */
    private $tags = [];

    /**
     * @var array
     */
    private $logs = [];

    /**
     * Span constructor.
     * @param Protocol $serializer
     * @param Transport $transporter
     * @param Context $context
     * @param int $startTime
     */
    public function __construct(
        Protocol $serializer,
        Transport $transporter,
        Context $context,
        int $startTime = null
    ) {
        $this->serializer = $serializer;
        $this->transporter = $transporter;
        $this->context = $context;
        $this->startAt = $startTime ?? $this->microseconds();
    }

    /**
     * @return string
     */
    public function getOperationName() : string
    {
        return $this->operation ?? 'none';
    }

    /**
     * @param string $newOperationName
     */
    public function overwriteOperationName($newOperationName) : void
    {
        if (!$this->permitted()) {
            return;
        }

        $this->operation = $newOperationName;
    }

    /**
     * @return SpanContext
     */
    public function getContext() : SpanContext
    {
        return $this->context;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags) : void
    {
        if (!$this->permitted()) {
            return;
        }

        $this->tags = array_merge($this->tags, $tags);
    }

    /**
     * @param array $fields
     * @param int $timestamp
     */
    public function log(array $fields = [], $timestamp = null) : void
    {
        if (!$this->permitted()) {
            return;
        }

        $fields && $this->logs[] = [$timestamp ?? $this->microseconds(), $fields];
    }

    /**
     * @param string $key
     * @return string
     */
    public function getBaggageItem($key) : ?string
    {
        return $this->getContext()->getBaggageItem($key);
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function addBaggageItem($key, $value) : void
    {
        if (!$this->permitted()) {
            return;
        }

        $this->context = $this->context->withBaggageItem($key, $value);
    }

    /**
     * @param int $finishTime
     * @param array $logRecords
     */
    public function finish($finishTime = null, array $logRecords = []) : void
    {
        if (!$this->permitted()) {
            return;
        }

        $this->endAt = $finishTime ?? $this->microseconds();

        if ($logRecords) {
            foreach ($logRecords as $logRecord) {
                $this->log($logRecord, $this->microseconds());
            }
        }

        $this->transporter->loading($this->serializer->serialize($this));

        $this->finished = true;
    }

    /**
     * @return bool
     */
    private function permitted() : bool
    {
        if ($this->finished) {
            trigger_error(self::E_FINISHED, E_USER_WARNING);
            return false;
        }
        return true;
    }
}
