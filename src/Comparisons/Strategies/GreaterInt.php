<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\ComparisonStrategy;

/**
 * The strategy that compares an Angle instance against a sexagesimal degrees 
 * measure of an angle to check if the first is greater than the last.
 */
class GreaterInt extends ComparisonStrategy
{
    /**
     * Construct the comparison strategy.
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
        return new GreaterAngle(
            $this->alfa, 
            Angle::createFromValues($this->beta)
        )->compare();
    }
}