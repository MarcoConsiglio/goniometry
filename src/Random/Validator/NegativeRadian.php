<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\Validator\Radian as RadianValidator;

class NegativeRadian extends RadianValidator
{
    public function validate(float &$min, float &$max): void
    {
        $this->avoidInvalidFloats($min, $max);
        $this->avoidPositiveValues($min, $max);
        $this->avoidExceedingValues($min, $max);
        $this->swap($min, $max);
    }

    public function avoidPositiveValues(float &$min, float &$max): void
    {
        if ($this->isPositive($min)) $this->setMin($min);
        if ($this->isPositive($max)) $this->setMax($max);
    }

    public function avoidExceedingValues(float &$min, float &$max): void
    {
        if ($this->lessThanOrEqual($min, -Radian::MAX)) $this->setMin($min);
        if ($this->lessThanOrEqual($max, -Radian::MAX)) $this->setMax($max);
    }

    protected function setMin(float &$value): void
    {
        $value = RadianRange::min();
    }

    protected function setMax(float &$value): void
    {
        $value = NextFloat::beforeZero();
    }
}