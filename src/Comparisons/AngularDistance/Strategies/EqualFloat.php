<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\FloatComparisonStrategy;

/**
 * The strategy that compares an `AngularDistance` instance against a sexadecimal angle 
 * measure to check if they are equal.
 * 
 * @internal
 */
class EqualFloat extends FloatComparisonStrategy
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

    public function compare(): bool
    {
        if ($this->bothAre180()) return true;
        return $this->alfa->toSexadecimalDegrees()->valueObject()->round($this->precision)
            ->eq(new Number($this->beta)->round($this->precision));
    }

    /**
     * Return `true` if both $alfa and $beta are ±180°.
     */
    protected function bothAre180(): bool
    {
        return 
            $this->alfa->toSexadecimalDegrees()->valueObject()->abs()->round($this->precision)
            ->eq(new Number($this->beta)->abs()->round($this->precision));
    }
}