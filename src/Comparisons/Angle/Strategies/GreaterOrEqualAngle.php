<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies;

use MarcoConsiglio\Goniometry\Comparisons\ComparisonStrategy;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;

/**
 * The strategy that compares two `Angle` instances to check if the first is 
 * greater or equal than the last.
 * 
 * @internal
 */
class GreaterOrEqualAngle extends ComparisonStrategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngleInterface $alfa The left comparison operand.
     * @param AngleInterface $beta The right comparison operand.
     */
    public function __construct(AngleInterface $alfa, protected AngleInterface $beta)
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