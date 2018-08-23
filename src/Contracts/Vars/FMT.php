<?php
/**
 * FMT related constants
 * User: moyo
 * Date: 2018/7/23
 * Time: 11:41 AM
 */

namespace Carno\Tracing\Contracts\Vars;

interface FMT
{
    /**
     * inject/extract from previous span context
     */
    public const PREV_CTX = 'prev_context';

    /**
     * @see \OpenTracing\Formats\HTTP_HEADERS
     */
    public const HTTP_HEADERS = 'http_headers';
}
