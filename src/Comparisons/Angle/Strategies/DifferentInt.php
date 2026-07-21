<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

/**
 * The strategy that compares an `Angle` instance against a sexagesimal integer 
 * degrees measure of an angle to check if they are different.
 * 
 * @internal
 */
class DifferentInt implements Strategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param Angle $alfa The left comparison operand.
     * @param int $beta The right comparison operand expressed as an integer
     * degrees measure.
     */
    public function __construct(
        protected Angle $alfa, 
        protected int $beta
    ) {}

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        return ! (new EqualInt($this->alfa, $this->beta)->compare());
    }
}