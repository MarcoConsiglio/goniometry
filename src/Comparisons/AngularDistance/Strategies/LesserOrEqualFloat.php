<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\FloatComparisonStrategy;
use Override;

/**
 * The strategy that compares an `AngularDistance` instance against a sexadecimal angle 
 * measure to check if the first is lesser or equal then the last.
 * 
 * @internal
 */
class LesserOrEqualFloat extends FloatComparisonStrategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularDistance $alfa The left comparison operand.
     * @param float $beta The right comparison operand.
     * @param int $precision The precision used in the comparison.
     */
    public function __construct(
        protected AngularDistance $alfa, 
        protected float $beta, 
        int $precision = Comparison::MAX_PRECISION
    ) {
        $this->normalizePrecision($precision);
    }

    #[Override]
    public function compare(): bool
    {
        return 
            new EqualFloat($this->alfa, $this->beta, $this->precision)->compare() ||
            new LesserFloat($this->alfa, $this->beta, $this->precision)->compare();
    }
}