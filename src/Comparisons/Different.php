<?php
namespace MarcoConsiglio\Goniometry\Comparisons;

/**
 * The Different comparison between angles.
 */
class Different extends Comparison
{
    /**
     * Set the comparison strategy based on the comparison type and
     * the type of the right operand of the comparison.
     */
    protected function setComparisonStrategy(): void
    {
        $this->comparison_strategy = $this->getBetaType()->getStrategyFor($this, $this->alfa);
    }

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        return $this->comparison_strategy->compare();
    }
}