<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Strategy;

/**
 * A comparison strategy.
 */
abstract class ComparisonStrategy implements Strategy
{
    
    /**
     * Construct the comparison strategy.
     * 
     * @param Angle $alfa The left comparison operand.
     */
    public function __construct(protected Angle $alfa) {}
}