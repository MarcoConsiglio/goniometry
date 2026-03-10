<?php
namespace MarcoConsiglio\Goniometry\Comparisons;

/**
 * The LesserOrEqual comparison between angles.
 */
class LesserOrEqual extends Comparison
{
    /**
     * Set the comparison strategy based on the comparison type and
     * the type of the right operand of the comparison.
     */
    protected function setComparisonStrategy(): void
    {
        $this->comparison_strategy = $this->getBetaType()->getStrategyFor($this, $this->alfa);
    }
}