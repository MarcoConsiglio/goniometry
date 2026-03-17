<?php
namespace MarcoConsiglio\Goniometry\Interfaces\Comparison;


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