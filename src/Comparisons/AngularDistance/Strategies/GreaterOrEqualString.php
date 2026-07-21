<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use Override;

/**
 * The strategy that compares an `AngularDistance` instance against a sexagesimal string 
 * measure of an angle to check if the first is greater or equal than the last.
 * 
 * @internal
 */
class GreaterOrEqualString implements Strategy
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

    #[Override]
    public function compare(): bool
    {
        $beta = AngularDistance::createFromString($this->beta);
        return 
            new EqualAngularDistance($this->alfa, $beta)->compare() ||
            new GreaterAngularDistance($this->alfa, $beta)->compare();
    }
}