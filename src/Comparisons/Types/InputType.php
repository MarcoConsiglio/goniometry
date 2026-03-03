<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Types;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Strategy;

abstract class InputType
{
    abstract public function getStrategyFor(Comparison $comparison, Angle $alfa): Strategy;
}