<?php
namespace MarcoConsiglio\Goniometry\Comparisons;

use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

/**
 * A comparison strategy against a `float` type variable.
 * 
 * @internal
 */
abstract class FloatComparisonStrategy implements Strategy
{
    /**
     * The precision used in the comparison.
     */
    protected int $precision = Comparison::MAX_PRECISION;

    /**
     * Check that the accuracy is within the permitted limits.
     * 
     * @codeCoverageIgnore
     */
    protected function normalizePrecision(int $precision): void {
        $precision = abs($precision);
        if ($precision > Comparison::MAX_PRECISION) 
            $precision = Comparison::MAX_PRECISION;
        $this->precision = $precision;
    }
}