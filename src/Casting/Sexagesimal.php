<?php
namespace MarcoConsiglio\Goniometry\Casting;

use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;
use MarcoConsiglio\Goniometry\Interfaces\SexadecimalValue;
/**
 * A caster object that cast from `Angle` interface type to other types.
 * 
 * @internal
 */
abstract class Sexagesimal
{
    /**
     * Construct the `Cast` object.
     */
    public function __construct(
        protected AngleInterface $angle,
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
    protected function toSexadecimal(): SexadecimalValue
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