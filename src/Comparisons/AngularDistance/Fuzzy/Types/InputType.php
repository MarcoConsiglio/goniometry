<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy\Types;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\InputType as BaseInputType;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

abstract class InputType extends BaseInputType
{
    /**
     * Construct the `InputType`.
     * 
     * @param AngularDistance $beta The right operand of the comparison.
     */
    public function __construct(
        protected AngularDistance $beta
    ) {}

    /**
     * Get the correct strategy for the current `$comparison` operation.
     * 
     * @param AngularDistance $alfa The left operand of the `$comparison`.
     */
    abstract public function getStrategyFor(Comparison $comparison, AngularDistance $alfa): Strategy;   
}