<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy;

use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy\Comparison as FuzzyComparison;
use Override;

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