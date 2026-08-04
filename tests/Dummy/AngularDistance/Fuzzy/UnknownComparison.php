<?php
namespace MarcoConsiglio\Goniometry\Tests\Dummy\AngularDistance\Fuzzy;

use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy\Comparison;
use Override;

class UnknownComparison extends Comparison
{
    #[Override]
    protected function setComparisonStrategy(): void
    {
        
    }
}