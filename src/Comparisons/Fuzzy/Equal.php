<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Fuzzy;

use MarcoConsiglio\Goniometry\Comparisons\Fuzzy\Comparison as FuzzyComparison;

/**
 * The `Equal` fuzzy comparison between angles.
 */
class Equal extends FuzzyComparison
{
    /**
     * Set the fuzzy comparison strategy based on the fuzzy comparison type and
     * the type of the right operand of the fuzzy comparison.
     */
    protected function setComparisonStrategy(): void
    {
        $this->comparison_strategy = 
            $this->getBetaType()
            ->setDelta($this->delta)
            ->getStrategyFor($this, $this->alfa);
    }
}