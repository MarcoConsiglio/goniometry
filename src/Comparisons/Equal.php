<?php
namespace MarcoConsiglio\Goniometry\Comparisons;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Types\EqualComparison;

/**
 * The `Equal` comparison between angles.
 */
class Equal extends Comparison
{
    /**
     * Set the comparison strategy based on the comparison type and
     * the type of the right operand of this `Comparison`.
     */
    protected function setComparisonStrategy(): void
    {
        $this->comparison_strategy = $this->getBetaType()->getStrategyFor($this, $this->alfa);
    }
}