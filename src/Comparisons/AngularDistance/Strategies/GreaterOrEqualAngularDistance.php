<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use Override;

/**
 * The strategy that compares two `AngularDistance` instances to check if the first is 
 * greater or equal than the last.
 * 
 * @internal
 */
class GreaterOrEqualAngularDistance implements Strategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularDistance $alfa The left comparison operand.
     * @param AngularDistance $beta The right comparison operand.
     */
    public function __construct(
        protected AngularDistance $alfa, 
        protected AngularDistance $beta
    ) {}

    #[Override]
    public function compare(): bool
    {
        return
            new EqualAngularDistance($this->alfa, $this->beta)->compare() ||
            new GreaterAngularDistance($this->alfa, $this->beta)->compare();
    }
}