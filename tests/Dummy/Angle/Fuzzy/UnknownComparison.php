<?php
namespace MarcoConsiglio\Goniometry\Tests\Dummy\Angle\Fuzzy;

use MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy\Comparison;
use Override;

class UnknownComparison extends Comparison
{
    #[Override]
    protected function setComparisonStrategy(): void
    {
        
    }
}