<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Types;

use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;

/**
 * The beta angle `InputType` in a comparison between alfa and beta angles.
 */
abstract class InputType
{
    /**
     * Get the correct strategy for the current `$comparison` operation.
     * 
     * @param AngleInterface $alfa The left operand of the `$comparison`.
     */
    abstract public function getStrategyFor(Comparison $comparison, AngleInterface $alfa): Strategy;
}