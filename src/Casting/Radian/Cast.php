<?php
namespace MarcoConsiglio\Goniometry\Casting\Radian;

use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\Interfaces\Casting\ToRadian;

/**
 * Cast sexagesimal values to radian.
 */
class Cast extends Sexagesimal implements ToRadian
{
    /**
     * Cast to radian.
     */
    public function cast(): float
    {
        $radian = $this->toSexadecimal()->value->toRadian();
        if ($this->hasPrecisionBeenSet())
            return $radian->toFloat($this->precision);
        return $radian->toFloat();
    }
}