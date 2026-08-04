<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy\Types;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\InputType as BaseInputType;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

abstract class InputType extends BaseInputType
{
    /**
     * Construct the `InputType`.
     * 
     * @param Angle $beta The right operand of the comparison.
     */
    public function __construct(
        protected Angle $beta
    ) {}

    /**
     * Get the correct strategy for the current `$comparison` operation.
     * 
     * @param Angle $alfa The left operand of the `$comparison`.
     */
    abstract public function getStrategyFor(Comparison $comparison, Angle $alfa): Strategy;   
}