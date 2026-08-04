<?php
namespace MarcoConsiglio\Goniometry\Interfaces\Angle;

use MarcoConsiglio\Goniometry\SexadecimalAngle;

interface BuildableFromSexadecimal
{
    /**
     * Create an `Angle` from its sexadecimal value.
     */
    public static function createFromDecimal(float|SexadecimalAngle $sexadecimal): static;
}