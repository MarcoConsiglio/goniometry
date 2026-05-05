<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;

/**
 * The strategy that compares an `Angle` instance against a sexagesimal string 
 * measure of an angle to check if the first is greater or equal than the last.
 * 
 * @internal
 */
class GreaterOrEqualString extends ComparisonStrategy
{    
    /**
     * Construct the comparison strategy.
     * 
     * @param AngleInterface $alfa The left comparison operand.
     * @param string $beta The right comparison operand expressed as a 
     * sexagesimal string angle measure.
     */
    public function __construct(AngleInterface $alfa, protected string $beta)
    {
        parent::__construct($alfa);
    }

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        $beta = Angle::createFromString($this->beta);
        return 
            new EqualAngle($this->alfa, $beta)->compare() ||
            new GreaterAngle($this->alfa, $beta)->compare();
    }
}