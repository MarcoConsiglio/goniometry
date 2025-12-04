<?php
namespace MarcoConsiglio\Goniometry\Exceptions;

use Exception;

/**
 * This exception is thrown when the angle regular expressions fails to find a string angle.
 */
class RegExFailureException extends Exception
{
    /**
     * It constructs the exception.
     *
     * @param string $message
     * @return void
     */
    public function __construct(string $message = "")
    {
        parent::__construct($message, 0, $this->getPrevious());
    }
}