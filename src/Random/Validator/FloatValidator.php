<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\Validation\Float\Validator;

/**
 * A validator that validate a `float` range.
 */
abstract class FloatValidator extends Validator
{
    protected function avoidInvalidFloats(float &$min, float &$max): void
    {
        if ($this->notAllowedFloat($min)) $this->setMin($min);
        if ($this->notAllowedFloat($max)) $this->setMax($max);
    }

    /**
     * Set the minimum allowed value.
     */
    abstract protected function setMin(float &$value): void;

    /**
     * Set the maximum allowed value.
     */
    abstract protected function setMax(float &$value): void;   
} 