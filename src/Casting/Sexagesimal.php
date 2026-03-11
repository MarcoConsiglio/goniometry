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
        if ($this->hasPrecisionBeenSet()) $this->normalizePrecision();
    } 

    /**
     * Check if the precision has been set.
     */
    protected function hasPrecisionBeenSet(): bool
    {
        return $this->precision !== null;
    }

    /**
     * Calc the sexadecimal value.
     */
    protected function toSexadecimal(): SexadecimalDegrees
    {
        return $this->angle->toDecimal();
    }

    /**
     * Normalize the precision to a suitable precision
     * when casting to float.
     */
    protected function normalizePrecision(): void
    {
        $this->precision = 
            abs($this->precision) > PHP_FLOAT_DIG ? 
            PHP_FLOAT_DIG : abs($this->precision);
    }
}