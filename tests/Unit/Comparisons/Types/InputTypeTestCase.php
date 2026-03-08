<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Types;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use ValueError;

abstract class InputTypeTestCase extends TestCase
{
    /**
     * Return a concrete mocked Comparison object.
     */
    protected function getMockedComparison(string $comparison_class): Comparison&MockObject
    {
        if (! class_exists($comparison_class)) 
            throw new ValueError("$comparison_class does not exists.");
        if (! is_subclass_of($comparison_class, Comparison::class)) 
            throw new ValueError("$comparison_class is not a child of ".Comparison::class.".");
        return $this->getMockBuilder($comparison_class)
                ->enableOriginalConstructor()
                ->setConstructorArgs([$this->getMockedAlfa(), $this->getMockedBeta()])
                ->getMock();
    }

    /**
     * Return the mocked alfa Angle.
     */
    abstract protected function getMockedAlfa(): Angle&MockObject;

    /**
     * Return the mocked beta Angle.
     */
    abstract protected function getMockedBeta(): Angle&MockObject;
}