<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use Override;

/**
 * Validate a `AngularDistanceRange` allowing only positive values.
 * 
 * @internal
 */
class PositiveAngularDistance extends AngularDistance
{
    /**
     * Validate the range.
     */
    #[Override]
    public function validate(float &$min, float &$max): void
    {
        $this->avoidInvalidFloats($min, $max);
        $this->avoidNegativeValues($min, $max);
        $this->avoidExceedingValues($min, $max);
        $this->swap($min, $max);
    }

    /**
     * Set the minimum allowed value.
     */
    #[Override]
    protected function setMin(float &$value): void
    {
        $value = 0.0;
    }

    /**
     * Set the maximum allowed value.
     */
    #[Override]
    protected function setMax(float &$value): void
    {
        $value = AngularDistanceRange::max();
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
        if ($this->greaterThanOrEqual($min, SexadecimalAngularDistance::MAX))
            $this->setMin($min);
        if ($this->greaterThanOrEqual($max, SexadecimalAngularDistance::MAX))
            $this->setMax($max);
    }
}