<?php
namespace MarcoConsiglio\Goniometry\Casting\Sexadecimal;

use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\Interfaces\Casting\ToSexadecimal;

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