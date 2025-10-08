<?php
namespace MarcoConsiglio\Goniometry\Exceptions;

use Exception;

/**
 * This exception is thrown when an angle regular expression fails.
 */
class RegExFailureException extends Exception
{
    /**
     * Constructs the exception.
     *
     * @param string $failure_message
     * @return void
     */
    public function __construct(string $failure_message = "")
    {
        parent::__construct($failure_message, 0, $this->getPrevious());
    }
}