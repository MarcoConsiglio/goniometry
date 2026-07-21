<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use Override;

/**
 * The strategy that compares an `AngularDistance` instance against a sexagesimal integer 
 * degrees measure of an angle to check if they are different.
 * 
 * @internal
 */
class DifferentInt implements Strategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularDistance $alfa The left comparison operand.
     * @param int $beta The right comparison operand.
     */
    public function __construct(
        protected AngularDistance $alfa, 
        protected int $beta
    ) {}

    #[Override]
    public function compare(): bool
    {
        return ! new EqualInt($this->alfa, $this->beta)->compare();
    }
}