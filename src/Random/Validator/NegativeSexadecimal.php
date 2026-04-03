<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;
use MarcoConsiglio\Goniometry\Degrees;

class NegativeSexadecimal extends SexadecimalValidator
{
    public function validate(float &$min, float &$max): void
    {
        $this->avoidInvalidFloats($min, $max);
        $this->avoidPositiveValues($min, $max);
        $this->avoidExceedingValues($min, $max);
        $this->swap($min, $max);
    }

    protected function avoidPositiveValues(float &$min, float &$max): void
    {
        if ($this->isPositive($min)) $this->setMin($min);
        if ($this->isPositive($max)) $this->setMax($max);
    }

    protected function avoidExceedingValues(float &$min, float &$max): void
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
        $value = NextFloat::beforeZero();
    }
}