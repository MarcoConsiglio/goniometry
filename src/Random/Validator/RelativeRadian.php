<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\RadianRange;

class RelativeRadian extends FloatValidator
{
    /**
     * Validate the range.
     */
    public function validate(float &$min, float &$max): void
    {
        $this->avoidInvalidFloats($min, $max);
        $this->avoidExceedingValues($min, $max);
        $this->swap($min, $max);
    }

    /**
     * Avoid values ​​that go beyond the permitted limit.
     */
    protected function avoidExceedingValues(float &$min, float &$max): void
    {
        $this->avoidTooHighValues($min, $max);
        $this->avoidTooLowValues($min, $max);
    }

    /**
     * Avoid values greater than the maximum limit.
     */
    protected function avoidTooHighValues(float &$min, float &$max): void
    {
        if ($this->greaterThanOrEqual($min, Radian::MAX)) $this->setMin($min);
        if ($this->greaterThanOrEqual($max, Radian::MAX)) $this->setMax($max);
    }

    /**
     * Avoid values less than the minimum limit.
     */
    protected function avoidTooLowValues(float &$min, float &$max): void
    {
        if ($this->lessThanOrEqual($min, -Radian::MAX)) $this->setMin($min);
        if ($this->lessThanOrEqual($max, -Radian::MAX)) $this->setMax($max);
    }

    /**
     * Set the minimum allowed value.
     */
    protected function setMin(float &$value): void
    {
        $value = RadianRange::min();
    }

    /**
     * Set the maximum allowed value.
     */
    protected function setMax(float &$value): void
    {
        $value = RadianRange::max();
    }
}