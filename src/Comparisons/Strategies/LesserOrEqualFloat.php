<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;

/**
 * The strategy that compares an `Angle` instance against a sexadecimal angle 
 * measure to check if the first is lesser or equal then the last.
 */
class LesserOrEqualFloat extends FloatComparisonStrategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param Angle $alfa The left comparison operand.
     * @param float $beta The right operand of the comparison.
     * @param int $precision The precision used in the comparison.
     */ 
    public function __construct(
        Angle $alfa,
        protected float $beta,
        protected int $precision = 54
    ) {
        parent::__construct($alfa);
    }

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        return
            $this->alfa->toSexadecimalDegrees()->value->round($this->precision)->abs()
            ->lte(
                new Number($this->beta)->round($this->precision)->abs()
            );
    }
}