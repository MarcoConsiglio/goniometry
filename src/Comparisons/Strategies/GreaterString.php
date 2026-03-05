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
     * Construct the comparison strategy.
     */
    public function __construct(Angle $alfa, protected string $beta)
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
            Angle::createFromString($this->beta)
        )->compare();
    }
}