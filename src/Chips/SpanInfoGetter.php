<?php
/**
 * Span info getter
 * User: moyo
 * Date: 24/11/2017
 * Time: 2:52 PM
 */

namespace Carno\Tracing\Chips;

trait SpanInfoGetter
{
    /**
     * @return int
     */
    public function getStartTime() : int
    {
        return $this->startAt;
    }

    /**
     * @return int
     */
    public function getFinishTime(): int
    {
        return $this->endAt;
    }

    /**
     * @return array
     */
    public function getTags() : array
    {
        return $this->tags;
    }

    /**
     * @return array
     */
    public function getLogs() : array
    {
        return $this->logs;
    }
}
