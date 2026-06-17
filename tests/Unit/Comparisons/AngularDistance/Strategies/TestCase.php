<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Strategies;

use Error;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\ComparisonStrategy;
use MarcoConsiglio\Goniometry\Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected string $comparison;

    protected function testCompare(
        string $strategy_class, 
        AngularDistance $alfa,
        int|float|string|AngularDistance $beta,
        bool $result = true
    ): void {
        if (! class_exists($strategy_class)) 
            throw new Error("$strategy_class class doesn't exist.");
        if (! is_subclass_of($strategy_class, $base = ComparisonStrategy::class)) 
            throw new Error("$strategy_class class is not a child of $strategy_class class.");
        $strategy = new $strategy_class($alfa, $beta);
        $message = $this->getFailMessage($alfa, $beta);
        if ($result === true) $this->assertCompareReturnTrue($strategy, $message);
        else $this->assertCompareReturnFalse($strategy, $message);
    }

    private function assertCompareReturnTrue(
        ComparisonStrategy $strategy, 
        string $message
    ): void {
        $this->assertTrue(
            $strategy->compare(),
            $message
        );
    }

    private function assertCompareReturnFalse(
        ComparisonStrategy $strategy, 
        string $message
    ): void {
        $this->assertFalse(
            $strategy->compare(),
            $message
        );
    }
    
    /**
     * Return a fail message for this TestCase.
     */
    protected function getFailMessage(AngularDistance $alfa, int|float|string|AngularDistance $beta): string
    {
        return $this->comparisonFail($alfa, $this->comparison, $beta);
    }

    /**
     * Return a fail message for this TestCase.
     */
    protected function getFailMessageWithDelta(Angle $delta, AngularDistance $alfa, int|float|string|AngularDistance $beta): string
    {
        $delta = $delta->absolute();
        return $this->comparisonFail($alfa, $this->comparison, $beta);
    }
}