<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\ComparisonStrategy;
use MarcoConsiglio\Goniometry\Enums\Direction;

/**
 * The strategy that compares an Angle instance against a sexagesimal degrees 
 * measure of an angle to check if they are equal.
 */
class GreaterInt extends ComparisonStrategy
{
    /**
     * The left comparison operand.
     */
    protected Angle $alfa;

    /**
     * The right comparison operand.
     */
    protected Angle $beta;

    public function __construct(Angle $alfa, int $beta)
    {
        parent::__construct($alfa);
        $this->beta = Angle::createFromValues(
            degrees: $beta
        );
    }

    public function compare(): bool
    {
        return new GreaterAngle($this->alfa, $this->beta)->compare();
    }
}