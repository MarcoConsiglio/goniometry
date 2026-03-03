<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;

/**
 * The strategy that compares two Angle instances to check if they are different.
 */
class DifferentAngle extends ComparisonStrategy
{
    /**
     * Construct the comparison strategy.
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
        return ! (new EqualAngle($this->alfa, $this->beta)->compare());
    }
}