<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Types;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\InputType as BaseInputType;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

abstract class InputType extends BaseInputType
{
    /**
     * Get the correct strategy for the current `$comparison` operation.
     * 
     * @param Angle $alfa The left operand of the `$comparison`.
     */
    abstract public function getStrategyFor(Comparison $comparison, Angle $alfa): Strategy;   
}