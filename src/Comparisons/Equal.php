<?php
namespace MarcoConsiglio\Goniometry\Comparisons;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Types\EqualComparison;

class Equal extends Comparison
{
    protected function setComparisonStrategy(): void
    {
        $this->comparison_strategy = $this->getBetaType()->getStrategyClassFor($this, $this->alfa);
    }

    public function compare(): bool
    {
        return $this->comparison_strategy->compare();
    }
}