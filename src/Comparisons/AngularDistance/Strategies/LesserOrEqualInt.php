<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use Override;

/**
 * The strategy that compares an `AngularDistance` instance against a sexagesimal degrees 
 * measure of an angle to check if the first is lesser or equal than the last.
 * 
 * @internal
 */
class LesserOrEqualInt implements Strategy
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
        $beta = AngularDistance::createFromValues(
            degrees: abs($this->beta),
            direction: $this->beta >= 0 ? 
                Rotation::COUNTER_CLOCKWISE : 
                Rotation::CLOCKWISE
        );
        return 
            new EqualAngularDistance($this->alfa, $beta)->compare() ||
            new LesserAngularDistance($this->alfa, $beta)->compare();
    }
}