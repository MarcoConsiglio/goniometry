<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;

/**
 * The strategy that compares an Angle instance agains a sexagesimal degrees 
 * measure of an angle to check if they are equal.
 */
class EqualFloat extends ComparisonStrategy
{
    /**
     * Construct the comparison strategy.
     */
    public function __construct(
        Angle $alfa, 
        protected float $beta, 
        protected int $precision = PHP_FLOAT_DIG
    ) {
        assert($precision >= 0 && $precision <= PHP_FLOAT_DIG);
        parent::__construct($alfa);
    }

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        return 
            $this->alfa->toDecimal($this->precision) == 
            new Number($this->beta)->toFloat($this->precision);
    }
}