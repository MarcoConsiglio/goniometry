<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\InputType as BaseInputType;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

abstract class InputType extends BaseInputType
{
    /**
     * Get the correct strategy for the current `$comparison` operation.
     * 
     * @param AngularDistance $alfa The left operand of the `$comparison`.
     */
    abstract public function getStrategyFor(Comparison $comparison, AngularDistance $alfa): Strategy;   
}