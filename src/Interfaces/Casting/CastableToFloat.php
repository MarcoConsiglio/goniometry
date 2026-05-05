<?php
namespace MarcoConsiglio\Goniometry\Interfaces\Casting;

/**
 * The behavior of a castable object.
 * 
 * @internal
 */
interface CastableToFloat
{
    /**
     * Cast to float.
     */
    public function cast(): float;
}