<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Comparisons\ComparisonStrategy;

/**
 * The strategy that compares an `Angle` instance against a sexagesimal string 
 * measure of an angle to check if they are different.
 * 
 * @internal
 */
class DifferentString extends ComparisonStrategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularMeasure $alfa The left comparison operand.
     * @param string $beta The right comparison operand expressed as a 
     * sexagesimal string angle measure.
     */
    public function __construct(AngularMeasure $alfa, protected string $beta)
    {
        parent::__construct($alfa);
    }

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        return new DifferentAngle(
            $this->alfa, Angle::createFromString($this->beta)
        )->compare();
    }
}