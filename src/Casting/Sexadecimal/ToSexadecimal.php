<?php
namespace MarcoConsiglio\Goniometry\Casting\Sexadecimal;

/**
 * The behavior that cast an `Angle` to a sexadecimal value.
 */
interface ToSexadecimal
{
    /**
     * Cast to float.
     */
    public function cast(): float;
}