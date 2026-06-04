<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Angle\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Tests\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected string $comparison;
    
    /**
     * Return a fail message for this TestCase.
     */
    protected function getFailMessage(Angle $alfa, int|float|string|Angle $beta): string
    {
        return $this->comparisonFail($alfa, $this->comparison, $beta);
    }
}