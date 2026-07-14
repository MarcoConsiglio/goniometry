<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentFloat as AngleDifferentFloat;
use Override;

/**
 * The strategy that compares an `AngularDistance` instance against a sexadecimal angle 
 * measure to check if they are different.
 * 
 * @internal
 */
class DifferentFloat extends AngleDifferentFloat
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularDistance $alfa The left comparison operand.
     * @param float $beta The right comparison operand.
     */
    public function __construct(AngularDistance $alfa, float $beta)
    {
        parent::__construct($alfa, $beta);
    }

    #[Override]
    public function compare(): bool
    {
        return ! new EqualFloat($this->alfa, $this->beta, $this->precision)->compare();
    }
}