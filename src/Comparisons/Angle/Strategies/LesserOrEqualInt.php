<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\ComparisonStrategy;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;

/**
 * The strategy that compares an `Angle` instance against a sexagesimal degrees 
 * measure of an angle to check if the first is lesser or equal than the last.
 * 
 * @internal
 */
class LesserOrEqualInt extends ComparisonStrategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngleInterface $alfa The left comparison operand.
     * @param int $beta The right comparison operand expressed as an integer
     * degrees measure.
     */
    public function __construct(AngleInterface $alfa, protected int $beta)
    {
        parent::__construct($alfa);
    }

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        $beta = Angle::createFromValues($this->beta);
        return 
            new EqualAngle($this->alfa, $beta)->compare() ||
            new LesserAngle($this->alfa, $beta)->compare();
    }
}