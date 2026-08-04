<?php
namespace MarcoConsiglio\Goniometry\Interfaces;

use MarcoConsiglio\Goniometry\Enums\Rotation;

interface BuildableFromSexagesimal
{
    /**
     * Create an `Angle` from its sexagesimal values.
     */
    public static function createFromValues(
        int $degrees, 
        int $minutes, 
        float $seconds, 
        Rotation $direction
    ): static;
}