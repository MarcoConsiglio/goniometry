<?php
namespace MarcoConsiglio\Goniometry\Tests\Dummy\AngularDistance;

use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Comparison;
use Override;

class UnknownComparison extends Comparison
{
    #[Override]
    protected function setComparisonStrategy(): void
    {
        
    }
}