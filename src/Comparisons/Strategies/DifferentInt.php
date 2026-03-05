<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;

/**
 * The strategy that compares an Angle instance against a sexagesimal integer 
 * degrees measure of an angle to check if they are different.
 */
class DifferentInt extends ComparisonStrategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param int $beta The right comparison operand expressed as an integer
     * degrees measure.
     */
    public function __construct(Angle $alfa, protected int $beta)
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