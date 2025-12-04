<?php
namespace MarcoConsiglio\Goniometry\Exceptions;

use Exception;

/**
 * This exception is thrown when a bad format string angle is matched,
 * for example `372° 88' 513"`.
 */
class NoMatchException extends Exception
{
    /**
     * It construct the exception.
     *
     * @param string $angle The string angle provoking the exception.
     * @return void
     */
    public function __construct(string $angle)
    {
        parent::__construct($angle." does not match an angle measure.", 0, $this->getPrevious());
    }
}