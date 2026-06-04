<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected string $comparison;
    
    /**
     * Return a fail message for this TestCase.
     */
    protected function getFailMessage(AngularDistance $alfa, int|float|string|AngularDistance $beta): string
    {
        return $this->comparisonFail($alfa, $this->comparison, $beta);
    }
}