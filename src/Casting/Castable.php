<?php
namespace MarcoConsiglio\Goniometry\Casting;

interface Castable
{
    /**
     * Cast to float.
     */
    public function cast(): float;
}