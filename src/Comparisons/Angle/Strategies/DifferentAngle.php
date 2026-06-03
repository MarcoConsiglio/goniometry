<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies;

use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Comparisons\ComparisonStrategy;

/**
 * The strategy that compares two `Angle` instances to check if they are different.
 * 
 * @internal
 */
class DifferentAngle extends ComparisonStrategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularMeasure $beta The left comparison operand.
     * @param AngularMeasure $beta The right operand of the comparison.
     */
    public function __construct(AngularMeasure $alfa, protected AngularMeasure $beta)
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