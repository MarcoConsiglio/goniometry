<?php
namespace MarcoConsiglio\Goniometry\Comparisons;

use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

/**
 * The beta angle `InputType` in a comparison between alfa and beta angles.
 * 
 * @internal
 */
abstract class InputType
{
    /**
     * Get the correct strategy for the current `$comparison` operation.
     * 
     * @param AngularMeasure $alfa The left operand of the `$comparison`.
     */
    abstract public function getStrategyFor(Comparison $comparison, AngularMeasure $alfa): Strategy;
}