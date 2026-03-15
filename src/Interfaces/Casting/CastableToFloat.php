<?php
namespace MarcoConsiglio\Goniometry\Interfaces\Casting;

/**
 * The behavior of a Castable object.
 */
interface CastableToFloat
{
    /**
     * Cast to float.
     */
    public function cast(): float;
}