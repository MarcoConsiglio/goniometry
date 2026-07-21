<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

/**
 * The strategy that compares an `Angle` instance against a sexagesimal string 
 * measure of an angle to check if they are equal.
 * 
 * @internal
 */
class EqualString implements Strategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param Angle $alfa The left comparison operand.
     * @param string $beta The right comparison operand expressed as a
     * sexagesimal string measure. 
     */
    public function __construct(
        protected Angle $alfa, 
        protected string $beta
    ) {}

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        return new EqualAngle(
            $this->alfa, 
            Angle::createFromString($this->beta)
        )->compare();
    }
}