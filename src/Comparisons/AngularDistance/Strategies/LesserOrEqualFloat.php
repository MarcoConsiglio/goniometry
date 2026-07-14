<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualFloat as AngleLesserOrEqualFloat;
use Override;

/**
 * The strategy that compares an `AngularDistance` instance against a sexadecimal angle 
 * measure to check if the first is lesser or equal then the last.
 * 
 * @internal
 */
class LesserOrEqualFloat extends AngleLesserOrEqualFloat
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularDistance $alfa The left comparison operand.
     * @param float $beta The right comparison operand.
     * @param int $precision The precision used in the comparison.
     */
    public function __construct(AngularDistance $alfa, float $beta, int $precision = 54)
    {
        parent::__construct($alfa, $beta, $precision);
    }

    #[Override]
    public function compare(): bool
    {
        return 
            new EqualFloat($this->alfa, $this->beta, $this->precision)->compare() ||
            new LesserFloat($this->alfa, $this->beta, $this->precision)->compare();
    }
}