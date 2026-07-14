<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy;

use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy\Comparison as FuzzyComparison;
use Override;

/**
 * The `Equal` fuzzy comparison between angular distances.
 * 
 * @internal
 */
class Equal extends FuzzyComparison
{
    #[Override]
    protected function setComparisonStrategy(): void
    {
        $this->comparison_strategy =
            $this->getBetaType()
                 ->setDelta($this->delta)
                 ->getStrategyFor($this, $this->alfa);
    }
}