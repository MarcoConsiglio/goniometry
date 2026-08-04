<?php
namespace MarcoConsiglio\Goniometry\Tests\Dummy\Angle;

use MarcoConsiglio\Goniometry\Comparisons\Angle\Comparison;
use Override;

class UnknownComparison extends Comparison
{
    #[Override]
    protected function setComparisonStrategy(): void
    {
        
    }
}