<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;

/**
 * The strategy that compares an `Angle` instance against a sexagesimal degrees 
 * measure of an angle to check if the first is greater or equal than the last.
 */
class GreaterOrEqualInt extends ComparisonStrategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param Angle $alfa The left comparison operand.
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
        $beta = Angle::createFromValues($this->beta);
        return 
            new EqualAngle($this->alfa, $beta)->compare() ||
            new GreaterAngle($this->alfa, $beta)->compare();
    }
}