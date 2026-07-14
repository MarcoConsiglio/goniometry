<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentAngle;
use Override;

/**
 * The strategy that compares two `AngularDistance` instances to check if they are different.
 * 
 * @internal
 */
class DifferentAngularDistance extends DifferentAngle
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularDistance $alfa The left comparison operand.
     * @param AngularDistance $beta The right comparison operand.
     */
    public function __construct(AngularDistance $alfa, AngularDistance $beta)
    {
        parent::__construct($alfa, $beta);
    }

    /**
     * Perform the comparison.
     */
    #[Override]
    public function compare(): bool
    {
        return ! new EqualAngularDistance($this->alfa, $this->beta)->compare();
    }
}