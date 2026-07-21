<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

/**
 * The strategy that compares an `Angle` instance against a sexagesimal degrees 
 * measure of an angle to check if the first is greater or equal than the last.
 * 
 * @internal
 */
class GreaterOrEqualInt implements Strategy
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
        $beta = Angle::createFromValues($this->beta);
        return 
            new EqualAngle($this->alfa, $beta)->compare() ||
            new GreaterAngle($this->alfa, $beta)->compare();
    }
}