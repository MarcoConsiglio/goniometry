<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;

/**
 * The strategy that compares two `Angle` instances to check if the first is 
 * greater or equal than the last.
 */
class GreaterOrEqualAngle extends ComparisonStrategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param Angle $alfa The left comparison operand.
     * @param Angle $beta The right comparison operand.
     */
    public function __construct(Angle $alfa, protected Angle $beta)
    {
        parent::__construct($alfa);
    }

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        return 
            new EqualAngle($this->alfa, $this->beta)->compare() ||
            new GreaterAngle($this->alfa, $this->beta)->compare();
    }
}