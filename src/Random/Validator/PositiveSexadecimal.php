<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;
use MarcoConsiglio\Goniometry\Degrees;

/**
 * Validate a `SexadecimalRange` allowing only positive values.
 */
class PositiveSexadecimal extends SexadecimalValidator
{
    /**
     * Validate the range.
     */
    public function validate(float &$min, float &$max): void
    {
        $this->avoidInvalidFloats($min, $max);
        $this->avoidNegativeValues($min, $max);
        $this->avoidExceedingValues($min, $max);
        $this->swap($min, $max);
    }

    /**
     * Avoid negative values.
     */
    protected function avoidNegativeValues(float &$min, float &$max): void
    {
        if ($this->isNegative($min)) $this->setMin($min);
        if ($this->isNegative($max)) $this->setMax($max);
    }

    /**
     * Avoid values ​​that go beyond the permitted limit.
     */
    protected function avoidExceedingValues(float &$min, float &$max): void
    {
        if ($this->greaterThanOrEqual($min, Degrees::MAX)) $this->setMin($min);        
        if ($this->greaterThanOrEqual($max, Degrees::MAX)) $this->setMax($max);
    }

    /**
     * Set the minimum allowed value.
     */
    protected function setMin(float &$value): void
    {
        $value = 0.0;
    }

    /**
     * Set the maximum allowed value.
     */
    protected function setMax(float &$value): void
    {
        $value = NextFloat::before(Degrees::MAX);
    }
}