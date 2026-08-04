<?php
namespace MarcoConsiglio\Goniometry\Interfaces\Angle;

use MarcoConsiglio\Goniometry\RadianAngle;

interface BuildableFromRadian
{
    /**
     * Create an `Angle` from its radian value.
     */
    public static function createFromRadian(float|RadianAngle $radian): static;
}