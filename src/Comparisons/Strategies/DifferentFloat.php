<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;

/**
 * The strategy that compares an Angle instance against a sexadecimal angle 
 * measure to check if they are different.
 */
class DifferentFloat extends ComparisonStrategy
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
        return parent::__construct($alfa);
    }

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        return ! (new EqualFloat($this->alfa, $this->beta, $this->precision)->compare());
    }
}