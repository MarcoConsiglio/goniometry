<?php
namespace MarcoConsiglio\Goniometry\Casting\Sexadecimal;

use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use RoundingMode;

/**
 * Cast an `Angle` to a sexadecimal value when the same `Angle` has already 
 * been constructed with a sexadecimal value.
 */
class Round extends Sexagesimal implements ToSexadecimal
{
    /**
     * Construct the `Round` object.
     */
    public function __construct(
        protected SexadecimalDegrees $sexadecimal,
        protected int|null $precision = null
    ) {}

    /**
     * Cast to float.
     */
    public function cast(): float
    {
        if ($this->hasPrecisionBeenSet()) {
            $this->normalizePrecision();
            return round(
                $this->sexadecimalToFloat(),
                $this->precision,
                RoundingMode::HalfTowardsZero
            );
        }
        return $this->sexadecimalToFloat();
    }

    /**
     * Return the sexadecimal degrees value as a 'float` type variable.
     */
    protected function sexadecimalToFloat(): float
    {
        return $this->sexadecimal->value->toFloat();
    }
}