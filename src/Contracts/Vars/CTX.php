<?php
/**
 * CTX related constants
 * User: moyo
 * Date: 2018/7/23
 * Time: 11:34 AM
 */

namespace Carno\Tracing\Contracts\Vars;

interface CTX
{
    /**
     * keys in coroutine's context
     */
    public const G_TRACER = 'cc.tracer';
    public const G_SPAN = 'cc.span';
    public const G_ROOT = 'cc.root';

    /**
     * standard context baggage keys
     */
    public const TRACE_ID = 'trace.id';
    public const TRACE_SAMPLED = 'trace.sampled';
    public const PARENT_SPAN_ID = 'span.parent.id';
    public const SPAN_ID = 'span.id';
}
