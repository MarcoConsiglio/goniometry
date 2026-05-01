<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use Override;

class PositiveAngularDistance extends AngularDistance
{
    #[Override]
    public function validate(float &$min, float &$max): void
    {
        $this->avoidInvalidFloats($min, $max);
        $this->avoidNegativeValues($min, $max);
        $this->avoidExceedingValues($min, $max);
        $this->swap($min, $max);
    }

    #[Override]
    protected function setMin(float &$value): void
    {
        $value = 0.0;
    }

    #[Override]
    protected function setMax(float &$value): void
    {
        $value = NextFloat::before(SexadecimalAngularDistance::MAX);
    }

    protected function avoidNegativeValues(float &$min, float &$max): void
    {
        if ($this->isNegative($min)) $this->setMin($min);
        if ($this->isNegative($max)) $this->setMax($max);
    }

    protected function avoidExceedingValues(float &$min, float &$max): void
    {
        if ($this->greaterThanOrEqual($min, SexadecimalAngularDistance::MAX))
            $this->setMin($min);
        if ($this->greaterThanOrEqual($max, SexadecimalAngularDistance::MAX))
            $this->setMax($max);
    }
}