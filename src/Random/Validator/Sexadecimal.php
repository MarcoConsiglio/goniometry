<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\Validation\Float\Validator;

abstract class Sexadecimal extends FloatValidator
{
    /**
     * Set the minimum allowed value.
     */
    abstract protected function setMin(float &$value): void;

    /**
     * Set the maximum allowed value.
     */
    abstract protected function setMax(float &$value): void;
} 