<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

/**
 * A comparison strategy against a `float` type variable.
 */
abstract class FloatComparisonStrategy extends ComparisonStrategy
{
    /**
     * Check that the accuracy is within the permitted limits.
     * 
     * @codeCoverageIgnore
     */
    protected function checkPrecision(int $precision) {
        assert($precision >= 0 && $precision <= 54);
    }
}