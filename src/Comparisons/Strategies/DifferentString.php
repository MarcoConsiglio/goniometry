<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;

/**
 * The strategy that compares an Angle instance against a sexagesimal string 
 * measure of an angle to check if they are different.
 */
class DifferentString extends ComparisonStrategy
{
    /**
     * The right comparison operand.
     */
    protected Angle $beta;

    /**
     * Construct the comparison strategy.
     */
    public function __construct(Angle $alfa, string $beta)
    {
        parent::__construct($alfa);
        $this->beta = Angle::createFromString($beta);
    }

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        return new DifferentAngle($this->alfa, $this->beta)->compare();
    }
}