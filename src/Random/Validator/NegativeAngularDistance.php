<?php

namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Random\Validator\AngularDistance as AngularDistanceValidator;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use Override;

/**
 * Validate a `AngularDistanceRange` allowing only negative values.
 * 
 * @internal
 */
class NegativeAngularDistance extends AngularDistanceValidator
{
    /**
     * Validate the range.
     */
    #[Override]
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
        if ($this->lessThanOrEqual($min, SexadecimalAngularDistance::MIN))
            $this->setMin($min);
        if ($this->lessThanOrEqual($max, SexadecimalAngularDistance::MIN))
            $this->setMax($max);
    }

    /**
     * Set the minimum allowed value.
     */
    #[Override]
    protected function setMin(float &$value): void
    {
        $value = AngularDistanceRange::min();
    }

    /**
     * Set the maximum allowed value.
     */
    #[Override]
    protected function setMax(float &$value): void
    {
        $value = NextFloat::beforeZero();
    }
}