<?php
namespace MarcoConsiglio\Goniometry\Interfaces\AngularDistance;

use MarcoConsiglio\Goniometry\RadianAngularDistance;

interface BuildableFromRadian
{
    /**
     * Create an `AngularDistance` from its radian value.
     */
    public static function createFromRadian(float|RadianAngularDistance $radian): static;
}