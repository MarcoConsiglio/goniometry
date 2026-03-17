<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Types;

use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\MockObject\Stub;
use ValueError;

abstract class InputTypeTestCase extends TestCase
{
    /**
     * Return a concrete Comparison stub object.
     */
    protected function getStubComparison(string $comparison_class): Comparison&Stub
    {
        if (! class_exists($comparison_class)) 
            throw new ValueError("$comparison_class does not exists.");
        if (! is_subclass_of($comparison_class, Comparison::class)) 
            throw new ValueError("$comparison_class is not a child of ".Comparison::class.".");
        return $this->createStub($comparison_class);
    }
}