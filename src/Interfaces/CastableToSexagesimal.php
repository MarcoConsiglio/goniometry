<?php
namespace MarcoConsiglio\Goniometry\Interfaces;

use MarcoConsiglio\Goniometry\SexagesimalDegrees;

interface CastableToSexagesimal
{
    /**
     * Return the sexagesimal values.
     */
    public function toSexagesimalDegrees(): SexagesimalDegrees;

    /**
     * Return an array containing the values of degrees, minutes, seconds. The 
     * direction is expressed as the sign of degrees.
     */
    public function getDegrees(): array;
}