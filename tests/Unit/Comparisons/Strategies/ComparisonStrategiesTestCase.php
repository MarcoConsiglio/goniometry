<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use ValueError;

class ComparisonStrategiesTestCase extends TestCase
{
    protected array $allowed_comparisons = [
        '<', '≤', '=', '≠', '>', '≥'
    ];

    protected function getComparisonFailMessage(
        Angle|float $alfa,
        string $comparison, 
        int|float|string|Angle $beta, 
        int $precision = PHP_FLOAT_DIG
    ) {
        if (! in_array($comparison, $this->allowed_comparisons))
            throw new ValueError("\"$comparison\" is not an allowed comparison.");
        $message = "$alfa $comparison $beta";
        if (is_float($beta))
            $message .= " with $precision digit precision";
        return $message."?";
    }
}