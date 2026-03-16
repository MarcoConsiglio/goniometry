<?php
namespace MarcoConsiglio\Goniometry\Comparisons;

use MarcoConsiglio\Goniometry\Angle;

/**
 * The behavior of a comparing strategy between angles.
 */
interface Strategy
{
    /**
     * Perform the comparison.
     */
    public function compare(): bool;
}