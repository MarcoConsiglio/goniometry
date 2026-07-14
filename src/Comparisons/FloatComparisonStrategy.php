<?php
namespace MarcoConsiglio\Goniometry\Comparisons;

use MarcoConsiglio\Goniometry\Comparisons\ComparisonStrategy;

/**
 * A comparison strategy against a `float` type variable.
 * 
 * @internal
 */
abstract class FloatComparisonStrategy extends ComparisonStrategy
{
    /**
     * Check that the accuracy is within the permitted limits.
     * 
     * @codeCoverageIgnore
     */
    protected function normalizePrecision(int $precision) {
        $precision = abs($precision);
        if ($precision > Comparison::MAX_PRECISION) 
            $precision = Comparison::MAX_PRECISION;
    }
}