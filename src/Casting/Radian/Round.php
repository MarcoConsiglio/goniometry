<?php
namespace MarcoConsiglio\Goniometry\Casting\Radian;

use MarcoConsiglio\Goniometry\AngularDistanceRadian;
use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\Interfaces\Casting\ToRadian;
use MarcoConsiglio\Goniometry\Radian;
use RoundingMode;

/**
 * Round a radian value
 */
class Round extends Sexagesimal implements ToRadian
{
    /**
     * Construct the `Round` object.
     */
    public function __construct(
        protected Radian|AngularDistanceRadian $radian,
        protected int|null $precision = null
    ) {}

    /**
     * Cast to float.
     */
    public function cast(): float
    {
        if ($this->hasPrecisionBeenSet()) {
            $this->normalizePrecision();
            return $this->radianToFloat($this->precision);
        }
        return $this->radianToFloat();
    }

    /**
     * Return the radian value as a `float` type variable.
     */
    protected function radianToFloat(int|null $precision = null): float
    {
        return $this->radian->value->toFloat($precision);
    }
}