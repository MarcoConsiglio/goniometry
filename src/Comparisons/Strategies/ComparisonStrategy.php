<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;
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
     * @param AngleInterface $alfa The left comparison operand.
     */
    public function __construct(protected AngleInterface $alfa) {}
}