<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;

/**
 * The strategy that compares an Angle instance against a sexagesimal string 
 * measure of an angle to check if the first is greater than the last.
 */
class GreaterString extends ComparisonStrategy
{
    /**
     * The left comparison operand.
     */
    protected Angle $alfa;

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
        return new GreaterAngle($this->alfa, $this->beta)->compare();
    }
}