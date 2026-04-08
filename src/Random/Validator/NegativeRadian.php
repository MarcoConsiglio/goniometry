<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\RadianRange;

class NegativeRadian extends FloatValidator
{
    /**
     * Validate the range.
     */
    public function validate(float &$min, float &$max): void
    {
        $this->avoidInvalidFloats($min, $max);
        $this->avoidPositiveValues($min, $max);
        $this->avoidExceedingValues($min, $max);
        $this->swap($min, $max);
    }

    /**
     * Avoid positive values.
     */
    public function avoidPositiveValues(float &$min, float &$max): void
    {
        if ($this->isPositive($min)) $this->setMin($min);
        if ($this->isPositive($max)) $this->setMax($max);
    }

    /**
     * Avoid values ​​that go beyond the permitted limit.
     */
    public function avoidExceedingValues(float &$min, float &$max): void
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
        $value = NextFloat::beforeZero();
    }
}