<?php
namespace MarcoConsiglio\Goniometry\Interfaces\AngularDistance;

use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;

interface BuildableFromSexadecimal
{
    /**
     * Create an `AngularDistance` from its sexadecimal value.
     */
    public static function createFromDecimal(float|SexadecimalAngularDistance $sexadecimal): static;
}