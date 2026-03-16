<?php
namespace MarcoConsiglio\Goniometry\Casting\Radian;

use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\Interfaces\Casting\ToRadian;
use MarcoConsiglio\Goniometry\Radian;
use RoundingMode;

class Round extends Sexagesimal implements ToRadian
{
    /**
     * Construct the `Round` object.
     */
    public function __construct(
        protected Radian $radian,
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
                $this->radianToFloat(),
                $this->precision,
                RoundingMode::HalfTowardsZero
            );
        }
        return $this->radianToFloat();
    }

    /**
     * Return the radian value as a `float` type variable.
     */
    protected function radianToFloat(): float
    {
        return $this->radian->value->toFloat();
    }
}