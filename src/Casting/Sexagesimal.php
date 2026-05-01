<?php
namespace MarcoConsiglio\Goniometry\Casting;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;

/**
 * Represents the sexagesimal starting point value to 
 * cast an `Angle` to other types.
 */
abstract class Sexagesimal
{
    /**
     * Construct the `Cast` object.
     */
    public function __construct(
        protected Angle|AngularDistance $angle,
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
    protected function toSexadecimal(): SexadecimalDegrees|SexadecimalAngularDistance
    {
        if ($this->angle instanceof Angle)
            return $this->angle->toSexadecimalDegrees();
        else return $this->angle->toSexadecimalAngularDistance();
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