<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies;

use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Comparisons\FloatComparisonStrategy;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;

/**
 * The strategy that compares an `Angle` instance against a sexadecimal angle 
 * measure to check if they are different.
 * 
 * @internal
 */
class DifferentFloat extends FloatComparisonStrategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularMeasure $alfa The left comparison operand.
     * @param float $beta The right operand of the comparison expressed as
     * a sexadecimal angle measure.
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
        return ! (new EqualFloat(
            $this->alfa, 
            $this->beta, 
            $this->precision
        )->compare());
    }
}