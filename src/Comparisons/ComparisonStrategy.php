<?php
namespace MarcoConsiglio\Goniometry\Comparisons;

use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

/**
 * A comparison strategy.
 * 
 * @internal
 */
abstract class ComparisonStrategy implements Strategy
{
    
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularMeasure $alfa The left comparison operand.
     */
    public function __construct(protected AngularMeasure $alfa) {}
}