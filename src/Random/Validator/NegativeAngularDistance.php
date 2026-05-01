<?php

namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Random\Validator\AngularDistance as AngularDistanceValidator;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use Override;

class NegativeAngularDistance extends AngularDistanceValidator
{
    #[Override]
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
        if ($this->lessThanOrEqual($min, SexadecimalAngularDistance::MIN))
            $this->setMin($min);
        if ($this->lessThanOrEqual($max, SexadecimalAngularDistance::MIN))
            $this->setMax($max);
    }

    #[Override]
    protected function setMin(float &$value): void
    {
        $value = NextFloat::after(SexadecimalAngularDistance::MIN);
    }

    #[Override]
    protected function setMax(float &$value): void
    {
        $value = NextFloat::beforeZero();
    }
}