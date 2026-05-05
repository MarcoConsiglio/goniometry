<?php
namespace MarcoConsiglio\Goniometry\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use Override;

/**
 * The `AngularDistance` random generator for relative values.
 * 
 * @internal
 */
class RelativeAngularDistance extends AngularDistance
{
    /**
     * Validate the range.
     */
    #[Override]
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
        $this->avoidTooLowValues($min, $max);
        $this->avoidTooHighValues($min, $max);
    }

    /**
     * Avoid too high values.
     */
    protected function avoidTooHighValues(float &$min, float &$max): void
    {
        if ($this->greaterThanOrEqual($min, SexadecimalAngularDistance::MAX))
            $this->setMin($min);
        if ($this->greaterThanOrEqual($max, SexadecimalAngularDistance::MAX))
            $this->setMax($max);
    }

    /**
     * Avoid too low values.
     */
    protected function avoidTooLowValues(float &$min, float &$max): void
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
        $value = AngularDistanceRange::max();
    }
}