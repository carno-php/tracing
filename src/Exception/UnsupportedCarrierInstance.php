<?php
/**
 * Unsupported inject carrier
 * User: moyo
 * Date: 19/12/2017
 * Time: 2:30 PM
 */

namespace Carno\Tracing\Exception;

use RuntimeException;

class UnsupportedCarrierInstance extends RuntimeException
{
    /**
     * @param string $type
     * @return UnsupportedCarrierInstance
     */
    public static function for(string $type) : self
    {
        return new self(sprintf('The carrier type \'%s\' is not supported.', $type));
    }
}
