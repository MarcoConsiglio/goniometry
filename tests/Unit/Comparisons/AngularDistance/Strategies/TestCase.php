<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Strategies;

use Error;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\ComparisonStrategy;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use MarcoConsiglio\Goniometry\Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected string $comparison;

    protected function testCompare(
        string $strategy_class, 
        AngularDistance $alfa,
        int|float|string|AngularDistance $beta,
        bool $expected_result = true
    ): void {
        $this->checkStrategy($strategy_class);
        $strategy = new $strategy_class($alfa, $beta);
        $message = $this->getFailMessage($alfa, $beta);
        if ($expected_result === true) $this->assertCompareReturnTrue($strategy, $message);
        else $this->assertCompareReturnFalse($strategy, $message);
    }

    protected function testFuzzyCompare(
        string $strategy_class,
        AngularDistance $alfa,
        AngularDistance $beta,
        Angle $delta,
        bool $expected_result = true
    ): void {
        $this->checkStrategy($strategy_class);
        $strategy = new $strategy_class($alfa, $beta, $delta);
        $message = $this->getFailMessageWithDelta($delta, $alfa, $beta);
        if ($expected_result === true) $this->assertCompareReturnTrue($strategy, $message);
        else $this->assertCompareReturnFalse($strategy, $message);
    }

    private function assertCompareReturnTrue(
        Strategy $strategy, 
        string $message
    ): void {
        $this->assertTrue(
            $strategy->compare(),
            $message
        );
    }

    private function assertCompareReturnFalse(
        Strategy $strategy, 
        string $message
    ): void {
        $this->assertFalse(
            $strategy->compare(),
            $message
        );
    }

    /**
     * @throws Error if `$strategy` doesn't exist or is not a child of `ComparisonStrategy`.
     */
    private function checkStrategy(string $strategy): void
    {
        if (! class_exists($strategy)) 
            throw new Error("$strategy class doesn't exist.");
        if (! is_subclass_of($strategy, $base = Strategy::class)) 
            throw new Error("$strategy class is not a child of $base class.");
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
        return $this->comparisonWithDeltaFail($alfa, $this->comparison, $beta, $delta);
    }
}