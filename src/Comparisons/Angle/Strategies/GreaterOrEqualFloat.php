<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Comparisons\FloatComparisonStrategy;

/**
 * The strategy that compares an `Angle` instance against a sexadecimal angle 
 * measure to check if the first is greater or equal than the last.
 * 
 * @internal
 */
class GreaterOrEqualFloat extends FloatComparisonStrategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularMeasure $alfa The left comparison operand.
     * @param float $beta The right operand of the comparison.
     * @param int $precision The precision used in the comparison.
     */  
    public function __construct(
        AngularMeasure $alfa, 
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
            $this->alfa->toSexadecimalDegrees()->value->round($this->precision)->abs()
            ->gte(
                new Number($this->beta)->round($this->precision)->abs()
            );
    }
}