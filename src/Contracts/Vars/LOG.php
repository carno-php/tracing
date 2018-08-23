<?php
/**
 * LOG related constants (overall)
 * User: moyo
 * Date: 2018/7/23
 * Time: 11:53 AM
 */

namespace Carno\Tracing\Contracts\Vars;

interface LOG
{
    /**
     * The type or "kind" of an error (only for event="error" logs). E.g., "Exception", "OSError"
     * @var string
     */
    public const ERROR_KIND = 'error.kind';

    /**
     * For languages that support such a thing (e.g., Java, Python)
     * the actual Throwable/Exception/Error object instance itself.
     * E.g., A java.lang.UnsupportedOperationException instance, a python exceptions.NameError instance
     * @var string
     * @see object
     */
    public const ERROR_OBJECT = 'error.object';

    /**
     * A stable identifier for some notable moment in the lifetime of a Span.
     * For instance, a mutex lock acquisition or release or the sorts of lifetime events
     * in a browser page load described in the Performance.timing specification.
     * E.g., from Zipkin, "cs", "sr", "ss", or "cr".
     * Or, more generally, "initialized" or "timed out".
     * For errors, "error"
     * @var string
     */
    public const EVENT = 'event';

    /**
     * A concise, human-readable, one-line message explaining the event.
     * E.g., "Could not connect to backend", "Cache invalidation succeeded"
     * @var string
     */
    public const MESSAGE = 'message';

    /**
     * A stack trace in platform-conventional format; may or may not pertain to an error.
     * @var string
     */
    public const STACK = 'stack';
}
