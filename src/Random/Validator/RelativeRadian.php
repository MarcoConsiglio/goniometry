<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\Validator\Radian as RadianValidator;

class RelativeRadian extends RadianValidator
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
        if ($this->greaterThanOrEqual($min, Radian::MAX)) $this->setMin($min);
        if ($this->greaterThanOrEqual($max, Radian::MAX)) $this->setMax($max);
    }

    protected function avoidTooLowValues(float &$min, float &$max): void
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
        $value = RadianRange::max();
    }
}