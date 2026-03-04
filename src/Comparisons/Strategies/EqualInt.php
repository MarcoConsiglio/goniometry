<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Enums\Direction;

/**
 * The strategy that compares an Angle instance agains a sexagesimal degrees 
 * measure of an angle to check if they are equal.
 */
class EqualInt extends ComparisonStrategy
{
    /**
     * The right comparison operand.
     */
    protected Angle $beta;

    /**
     * Construct the comparison strategy.
     * 
     * @param int $beta The right comparison operand expressed as an integer
     * degrees measure.
     */
    public function __construct(Angle $alfa, int $beta)
    {
        parent::__construct($alfa);
        $this->beta = Angle::createFromValues(
            degrees: $beta, 
            direction: $beta >= 0 ? Direction::COUNTER_CLOCKWISE : Direction::CLOCKWISE
        );
    }

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        return new EqualAngle($this->alfa, $this->beta)->compare();
    }
}