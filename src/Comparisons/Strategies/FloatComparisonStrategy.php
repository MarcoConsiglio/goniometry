<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

abstract class FloatComparisonStrategy extends ComparisonStrategy
{
    protected function checkPrecision(int $precision) {
        assert($precision >= 0 && $precision <= 54);
    }
}