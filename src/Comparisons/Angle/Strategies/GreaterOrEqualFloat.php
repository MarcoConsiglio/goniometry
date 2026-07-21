<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\FloatComparisonStrategy;

/**
 * The strategy that compares an `Angle` instance against a sexadecimal angle 
 * measure to check if the first is greater or equal than the last.
 * 
 * @internal
 */
class GreaterOrEqualFloat extends FloatComparisonStrategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param Angle $alfa The left comparison operand.
     * @param float $beta The right operand of the comparison.
     * @param int $precision The precision used in the comparison.
     */  
    public function __construct(
        protected Angle $alfa, 
        protected float $beta,
        int $precision = Comparison::MAX_PRECISION
    ) {
        $this->normalizePrecision($precision);
    }

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        return
            $this->alfa->toSexadecimalDegrees()->value->round($this->precision)->abs()
            ->gte(
                new Number($this->beta)->round($this->precision)->abs()
            );
    }
}