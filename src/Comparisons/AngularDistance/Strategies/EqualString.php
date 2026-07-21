<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

/**
 * The strategy that compares an `AngularDistance` instance against a sexagesimal string 
 * measure of an angle to check if they are equal.
 * 
 * @internal
 */
class EqualString implements Strategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularDistance $alfa The left comparison operand.
     * @param string $beta The right comparison operand.
     */
    public function __construct(
        protected AngularDistance $alfa, 
        protected string $beta
    ) {}

    public function compare(): bool
    {
        return new EqualAngularDistance(
            $this->alfa,
            AngularDistance::createFromString($this->beta)
        )->compare();
    }
}