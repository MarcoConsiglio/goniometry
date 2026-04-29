<?php
namespace MarcoConsiglio\Goniometry\Interfaces\Casting;

/**
 * The behavior of a castable object.
 */
interface CastableToFloat
{
    /**
     * Cast to float.
     */
    public function cast(): float;
}