<?php
namespace MarcoConsiglio\Goniometry\Comparisons;

abstract class Comparison
{
    /**
     * The precision used when comparing an `Angle` against a `float` type 
     * variable.
     */
    protected int $precision = self::MAX_PRECISION;

    /**
     * The maximum allowed precision in every comparison.
     */
    public const int MAX_PRECISION = 54;   
}