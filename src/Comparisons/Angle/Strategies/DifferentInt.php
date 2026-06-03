<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies;

use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Comparisons\ComparisonStrategy;

/**
 * The strategy that compares an `Angle` instance against a sexagesimal integer 
 * degrees measure of an angle to check if they are different.
 * 
 * @internal
 */
class DifferentInt extends ComparisonStrategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularMeasure $alfa The left comparison operand.
     * @param int $beta The right comparison operand expressed as an integer
     * degrees measure.
     */
    public function __construct(AngularMeasure $alfa, protected int $beta)
    {
        parent::__construct($alfa);
    }

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        return ! (new EqualInt($this->alfa, $this->beta)->compare());
    }
}