<?php
/**
 * Carrier API
 * User: moyo
 * Date: 23/11/2017
 * Time: 4:31 PM
 */

namespace Carno\Tracing\Contracts;

use Carno\HTTP\Standard\Message;
use Carno\Tracing\Contracts\CC\Extractor;
use Carno\Tracing\Contracts\CC\Generator;
use Carno\Tracing\Contracts\CC\Injector;
use Carno\Tracing\Standard\Context;

interface Carrier extends Extractor, Injector, Generator
{
    /**
     * @param Context $context
     * @return static
     */
    public function ctx(Context $context) : Carrier;

    /**
     * @param Message $message
     * @return static
     */
    public function http(Message $message) : Carrier;
}
