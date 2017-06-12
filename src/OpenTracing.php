<?php

use OpenTracing\Tracer;
use OpenTracing\NullTracer;
use OpenTracing\Span;
use OpenTracing\SpanContext;

final class OpenTracing
{
    const FORMAT_TEXT_MAP = 1;
    const FORMAT_BINARY = 2;
    const FORMAT_HTTP_HEADERS = 3;
    const FORMAT_SERVER_GLOBALS = 4;

    const VERSION = "0.3.0";

    private static $tracer;

    public static function setGlobalTracer(Tracer $tracer)
    {
        self::$tracer = $tracer;
    }

    private static function getGlobalTracer()
    {
        if (self::$tracer === null) {
            self::$tracer = new NullTracer();
        }

        return self::$tracer;
    }

    /**
     * @param string $operationName
     * @param array|SpanOptions $options
     * @return \OpenTracing\Span
     */
    public static function startSpan($operationName, array $options = array())
    {
        return self::getGlobalTracer()->startSpan($operationName, $options);
    }

    /**
     * @param string $format
     * @param mixed $carrier
     */
    public static function inject(SpanContext $context, $format, $carrier)
    {
        return self::getGlobalTracer()->inject($context, $format, $carrier);
    }

    /**
     * @param string $format
     * @param mixed $carrier
     * @return \OpenTracing\SpanContext
     */
    public static function extract($format, $carrier)
    {
        return self::getGlobalTracer()->extract($format, $carrier);
    }
}
