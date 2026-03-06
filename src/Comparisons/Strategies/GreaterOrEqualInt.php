<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;

class GreaterOrEqualInt extends ComparisonStrategy
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
        $beta = Angle::createFromValues($this->beta);
        return 
            new EqualAngle($this->alfa, $beta)->compare() ||
            new GreaterAngle($this->alfa, $beta)->compare();
    }
}