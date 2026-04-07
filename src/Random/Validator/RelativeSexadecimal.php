<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;
use MarcoConsiglio\Goniometry\Degrees;

class RelativeSexadecimal extends SexadecimalValidator
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
        if ($this->greaterThanOrEqual($min, Degrees::MAX)) $this->setMin($min);
        if ($this->greaterThanOrEqual($max, Degrees::MAX)) $this->setMax($max);
    }

    /**
     * Avoid values less than the minimum limit.
     */
    protected function avoidTooLowValues(float &$min, float &$max): void
    {
        if ($this->lessThanOrEqual($min, -Degrees::MAX)) $this->setMin($min);
        if ($this->lessThanOrEqual($max, -Degrees::MAX)) $this->setMax($max);
    }

    /**
     * Set the minimum allowed value.
     */
    protected function setMin(float &$value): void
    {
        $value = NextFloat::after(-Degrees::MAX);
    }

    /**
     * Set the maximum allowed value.
     */
    protected function setMax(float &$value): void
    {
        $value = NextFloat::before(Degrees::MAX);
    }
}