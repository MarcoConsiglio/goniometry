<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;

/**
 * The strategy that compares an Angle instance against a sexagesimal string 
 * measure of an angle to check if the first is greater than the last.
 */
class LesserString extends ComparisonStrategy
{    
    /**
     * Construct the comparison strategy.
     * 
     * @param string $beta The right comparison operand expressed as a 
     * sexagesimal string angle measure.
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
        return new LesserAngle(
            $this->alfa, 
            Angle::createFromString($this->beta)
        )->compare();
    }
}