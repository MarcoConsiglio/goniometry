<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentInt as AngleDifferentInt;
use Override;

/**
 * The strategy that compares an `AngularDistance` instance against a sexagesimal integer 
 * degrees measure of an angle to check if they are different.
 * 
 * @internal
 */
class DifferentInt extends AngleDifferentInt
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularDistance $alfa The left comparison operand.
     * @param int $beta The right comparison operand.
     */
    public function __construct(AngularDistance $alfa, int $beta)
    {
        parent::__construct($alfa, $beta);
    }

    #[Override]
    public function compare(): bool
    {
        return ! new EqualInt($this->alfa, $this->beta)->compare();
    }
}