<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;
use MarcoConsiglio\Goniometry\Degrees;

class RelativeSexadecimal extends SexadecimalValidator
{
    public function validate(float &$min, float &$max): void
    {
        $this->avoidInvalidFloats($min, $max);
        $this->avoidExceedingValues($min, $max);
        $this->swap($min, $max);
    }

    protected function avoidExceedingValues(float &$min, float &$max): void
    {
        $this->avoidTooHighValues($min, $max);
        $this->avoidTooLowValues($min, $max);
    }

    protected function avoidTooHighValues(float &$min, float &$max): void
    {
        if ($this->greaterThanOrEqual($min, Degrees::MAX)) $this->setMin($min);
        if ($this->greaterThanOrEqual($max, Degrees::MAX)) $this->setMax($max);
    }

    protected function avoidTooLowValues(float &$min, float &$max): void
    {
        if ($this->lessThanOrEqual($min, -Degrees::MAX)) $this->setMin($min);
        if ($this->lessThanOrEqual($max, -Degrees::MAX)) $this->setMax($max);
    }

    protected function setMin(float &$value): void
    {
        $value = NextFloat::after(-Degrees::MAX);
    }

    protected function setMax(float &$value): void
    {
        $value = NextFloat::before(Degrees::MAX);
    }
}