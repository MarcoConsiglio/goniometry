<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

/**
 * The strategy that compares two `Angle` instances to check if they are different.
 * 
 * @internal
 */
class DifferentAngle implements Strategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param Angle $beta The left comparison operand.
     * @param Angle $beta The right operand of the comparison.
     */
    public function __construct(
        protected Angle $alfa, 
        protected Angle $beta
    ) {}

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        return ! (new EqualAngle($this->alfa, $this->beta)->compare());
    }
}