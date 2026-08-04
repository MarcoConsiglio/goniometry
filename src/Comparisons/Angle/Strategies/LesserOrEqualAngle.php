<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

/**
 * The strategy that compares two `Angle` instances to check if the first is 
 * lesser or equal then the last.
 * 
 * @internal
 */
class LesserOrEqualAngle implements Strategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param Angle $alfa The left comparison operand.
     * @param Angle $beta The right comparison operand.
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
        return 
            new EqualAngle($this->alfa, $this->beta)->compare() ||
            new LesserAngle($this->alfa, $this->beta)->compare();
    }
}