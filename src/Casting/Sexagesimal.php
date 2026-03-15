<?php
namespace MarcoConsiglio\Goniometry\Casting;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;

abstract class Sexagesimal
{
    /**
     * Construct the `Cast` object.
     */
    public function __construct(
        protected Angle $angle,
        protected int|null $precision = null
    ) {
        if ($this->hasPrecisionBeenSet()) {
            $this->disallowNegativePrecision();
            $this->normalizePrecision();
        }
    } 

    /**
     * Check if the precision has been set.
     */
    protected function hasPrecisionBeenSet(): bool
    {
        return $this->precision !== null;
    }

    /**
     * Transform a negative precision into a positive precision.
     */
    protected function disallowNegativePrecision(): void
    {
        $this->precision = abs($this->precision);
    }

    /**
     * Calc the sexadecimal value.
     */
    protected function toSexadecimal(): SexadecimalDegrees
    {
        return $this->angle->toSexadecimalDegrees();
    }

    /**
     * Normalize the precision to a suitable precision
     * when casting to float.
     */
    protected function normalizePrecision(): void
    {
        if ($this->precision > PHP_FLOAT_DIG)
            $this->precision = PHP_FLOAT_DIG;
    }
}