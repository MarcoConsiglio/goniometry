<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;
use MarcoConsiglio\Goniometry\Degrees;

/**
 * Validate a `SexadecimalRange` allowing only negative values.
 */
class NegativeSexadecimal extends SexadecimalValidator
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
    protected function avoidPositiveValues(float &$min, float &$max): void
    {
        if ($this->isPositive($min)) $this->setMin($min);
        if ($this->isPositive($max)) $this->setMax($max);
    }

    /**
     * Avoid values ​​that go beyond the permitted limit.
     */
    protected function avoidExceedingValues(float &$min, float &$max): void
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
        $value = NextFloat::beforeZero();
    }
}