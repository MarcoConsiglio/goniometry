<?php
namespace MarcoConsiglio\Goniometry\Exceptions;

use Exception;

/**
 * This exception is thrown when the angle regular expressions fails to find a string angle.
 * 
 * @deprecated <> Use NoMatchException instead.
 */
class RegExFailureException extends Exception
{
    /**
     * Construct the `RegExFailureException`.
     */
    public function __construct(string $message = "")
    {
        parent::__construct($message, 0, $this->getPrevious());
    }
}