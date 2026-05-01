<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use Override;

class RelativeAngularDistance extends AngularDistance
{
    #[Override]
    public function validate(float &$min, float &$max): void
    {
        $this->avoidInvalidFloats($min, $max);
        $this->avoidExceedingValues($min, $max);
        $this->swap($min, $max);
    }
    
    protected function avoidExceedingValues(float &$min, float &$max): void
    {
        $this->avoidTooLowValues($min, $max);
        $this->avoidTooHighValues($min, $max);
    }

    protected function avoidTooHighValues(float &$min, float &$max): void
    {
        if ($this->greaterThanOrEqual($min, SexadecimalAngularDistance::MAX))
            $this->setMin($min);
        if ($this->greaterThanOrEqual($max, SexadecimalAngularDistance::MAX))
            $this->setMax($max);
    }

    protected function avoidTooLowValues(float &$min, float &$max): void
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
        $value = NextFloat::before(SexadecimalAngularDistance::MAX);
    }
}