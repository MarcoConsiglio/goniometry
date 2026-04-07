<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\RadianRange;

class PositiveRadian extends FloatValidator
{
    public function validate(float &$min, float &$max): void
    {
        $this->avoidInvalidFloats($min, $max);
        $this->avoidNegativeValues($min, $max);
        $this->avoidExceedingValues($min, $max);
        $this->swap($min, $max);
    }

    protected function avoidNegativeValues(float &$min, float &$max): void
    {
        if ($this->isNegative($min)) $this->setMin($min);
        if ($this->isNegative($max)) $this->setMax($max);
    }

    protected function avoidExceedingValues(float &$min, float &$max): void
    {
        if ($this->greaterThanOrEqual($min, Radian::MAX)) $this->setMin($min);
        if ($this->greaterThanOrEqual($max, Radian::MAX)) $this->setMax($max);
    }

    protected function setMin(float &$value): void
    {
        $value = 0.0;
    }

    protected function setMax(float &$value): void
    {
        $value = RadianRange::max();
    }
}