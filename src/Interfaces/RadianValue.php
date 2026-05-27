<?php
namespace MarcoConsiglio\Goniometry\Interfaces;

use MarcoConsiglio\BCMathExtended\Number;

interface RadianValue extends Scalar
{
    public static function getMaxRadian(): Number;
}