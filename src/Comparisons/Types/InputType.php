<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Types;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

/**
 * The beta angle `InputType` in a comparison between alfa and beta angles.
 */
abstract class InputType
{
    /**
     * Get the correct strategy for the current $comparison operation.
     */
    abstract public function getStrategyFor(Comparison $comparison, Angle $alfa): Strategy;
}