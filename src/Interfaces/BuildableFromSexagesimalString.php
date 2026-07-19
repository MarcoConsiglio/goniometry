<?php
namespace MarcoConsiglio\Goniometry\Interfaces;

interface BuildableFromSexagesimalString
{
    /**
     * Create an `AngularDistance` from a sexagesimal `string`.
     */
    public static function createFromString(string $sexagesimal): static;
}