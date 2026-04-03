<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use Faker\Generator as FakerGenerator;
use MarcoConsiglio\FakerPhpNumberHelpers\Validation\Float\Validator;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;

abstract class Sexadecimal extends Validator
{
    protected function avoidInvalidFloats(float &$min, float &$max): void
    {
        if ($this->notAllowedFloat($min)) $this->setMin($min);
        if ($this->notAllowedFloat($max)) $this->setMax($max);
    }

    abstract protected function setMin(float &$value): void;

    abstract protected function setMax(float &$value): void;
} 