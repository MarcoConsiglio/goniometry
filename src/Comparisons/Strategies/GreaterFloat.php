<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;

/**
 * The strategy that compares an Angle instance against a sexadecimal angle 
 * measure to check if the first is greater than the last.
 */
class GreaterFloat extends ComparisonStrategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param float $beta The right operand of the comparison.
     * @param int $precision The precision used in the comparison.
     */     
    public function __construct(
        Angle $alfa, 
        protected float $beta, 
        protected int $precision = PHP_FLOAT_DIG
    ) {
        parent::__construct($alfa);
    }

    public function compare(): bool
    {
        return $this->alfa->toDecimal($this->precision) >
            new Number($this->beta)->toFloat($this->precision);
    }
}