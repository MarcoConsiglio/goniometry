<?php
namespace MarcoConsiglio\Goniometry\Interfaces;

use MarcoConsiglio\BCMathExtended\Number;

/**
 * The behavior of a radian value.
 */
interface RadianValue extends Scalar
{
    public static function getMaxRadian(): Number;
}