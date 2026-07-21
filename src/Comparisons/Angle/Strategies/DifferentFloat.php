<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\FloatComparisonStrategy;

/**
 * The strategy that compares an `Angle` instance against a sexadecimal angle 
 * measure to check if they are different.
 * 
 * @internal
 */
class DifferentFloat extends FloatComparisonStrategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param Angle $alfa The left comparison operand.
     * @param float $beta The right operand of the comparison expressed as
     * a sexadecimal angle measure.
     * @param int $precision The precision used in the comparison.
     */
    public function __construct(
        protected Angle $alfa,
        protected float $beta,
        protected int $precision = Comparison::MAX_PRECISION
    ) {
        $this->normalizePrecision($precision);
    }

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        return ! (new EqualFloat(
            $this->alfa, 
            $this->beta, 
            $this->precision
        )->compare());
    }
}