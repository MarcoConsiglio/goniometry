<?php
namespace MarcoConsiglio\Goniometry\Tests\Dummy;

use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use Override;

class UnknownComparison extends Comparison
{
    #[Override]
    protected function setComparisonStrategy(): void
    {
        
    }
}