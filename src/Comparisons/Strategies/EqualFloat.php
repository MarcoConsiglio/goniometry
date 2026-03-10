<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;

/**
 * The strategy that compares an Angle instance against a sexadecimal angle 
 * measure to check if they are equal.
 */
class EqualFloat extends FloatComparisonStrategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param Angle $alfa The left comparison operand.
     * @param float $beta The right operand of the comparison expressed as a
     * sexadecimal angle measure.
     * @param int $precision The precision used in the comparison.
     */
    public function __construct(
        Angle $alfa, 
        protected float $beta, 
        protected int $precision = 54
    ) {
        $this->checkPrecision($precision);
        parent::__construct($alfa);
    }

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        return 
            $this->alfa->toDecimal()->abs()->round($this->precision)
            ->eq(new Number($this->beta)->abs()->round($this->precision));
    }
}