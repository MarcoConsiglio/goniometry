<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\FakerPhpNumberHelpers\Validation\Float\Validator;
use MarcoConsiglio\Goniometry\Degrees;

class NegativeSexadecimal extends Validator
{
    public function validate(float &$min, float &$max): void
    {
        $this->avoidInvalidFloats($min, $max);
        $this->avoidPositiveValues($min, $max);
        $this->avoidExceedingValues($min, $max);
    }

    protected function avoidInvalidFloats(float &$min, float &$max): void
    {
        if ($this->notAllowedFloat($min)) $this->setMin($min);
        if ($this->notAllowedFloat($max)) $this->setMax($max);
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