<?php
namespace MarcoConsiglio\Goniometry\Interfaces;

use MarcoConsiglio\Goniometry\Interfaces\SexadecimalValue;

interface CastableToSexadecimal
{
    /**
     * Return the sexadecimal values.
     */
    public function toSexadecimalDegrees(): SexadecimalValue;

    /**
     * Return the `float` sexadecimal value.
     */
    public function toFloat(int $precision = PHP_FLOAT_DIG): float;
}