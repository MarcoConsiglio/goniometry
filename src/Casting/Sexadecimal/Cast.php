<?php
namespace MarcoConsiglio\Goniometry\Casting\Sexadecimal;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;

/**
 * Cast sexagesimal values to sexadecimal.
 */
class Cast extends Sexagesimal implements ToSexadecimal
{
    /**
     * Cast to sexadecimal.
     */
    public function cast(): float
    {
        $decimal = $this->toSexadecimal();
        if ($this->hasPrecisionBeenSet())
            return $decimal->value->toFloat($this->precision);
        $this->precision = $decimal->value->scale;
        $this->normalizePrecision();
        return $decimal->value->toFloat($this->precision);
    }
}