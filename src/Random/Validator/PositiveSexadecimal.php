<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\FakerPhpNumberHelpers\Validation\Float\Validator;
use MarcoConsiglio\Goniometry\Degrees;

class PositiveSexadecimal extends Validator
{
    public function validate(float &$min, float &$max): void
    {
        $this->avoidInvalidFloats($min, $max);
        $this->avoidNegativeValues($min, $max);
        $this->avoidExceedingValues($min, $max);
        $this->swap($min, $max);
    }

    protected function avoidInvalidFloats(float &$min, float &$max): void
    {
        if ($this->notAllowedFloat($min)) $this->setMin($min);
        if ($this->notAllowedFloat($max)) $this->setMax($max);
    }

    protected function avoidNegativeValues(float &$min, float &$max): void
    {
        if ($this->isNegative($min)) $this->setMin($min);
        if ($this->isNegative($max)) $this->setMax($max);
    }

    protected function avoidExceedingValues(float &$min, float &$max): void
    {
        if ($this->greaterThanOrEqual($min, Degrees::MAX)) $this->setMin($min);        
        if ($this->greaterThanOrEqual($max, Degrees::MAX)) $this->setMax($max);
    }

    protected function setMin(float &$value): void
    {
        $value = 0.0;
    }

    protected function setMax(float &$value): void
    {
        $value = NextFloat::before(Degrees::MAX);
    }
}