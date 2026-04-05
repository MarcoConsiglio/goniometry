<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\Validation\Float\Validator;

abstract class Radian extends Validator
{
    protected function avoidInvalidFloats(float &$min, float &$max): void
    {
        if ($this->notAllowedFloat($min)) $this->setMin($min);
        if ($this->notAllowedFloat($max)) $this->setMax($max);
    }

    abstract protected function setMin(float &$value): void;

    abstract protected function setMax(float &$value): void;   
} 