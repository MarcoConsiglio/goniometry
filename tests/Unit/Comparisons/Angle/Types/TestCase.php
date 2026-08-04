<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Angle\Types;

use Error;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\InputType;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use MarcoConsiglio\Goniometry\Tests\Dummy\Angle\UnknownComparison;
use MarcoConsiglio\Goniometry\Tests\TestCase as BaseTestCase;
use Override;
use PHPUnit\Framework\MockObject\Stub;

abstract class TestCase extends BaseTestCase
{
    protected Angle&Stub $alfa;
    
    protected (Angle&Stub)|float|int|string $beta;

    protected InputType $input_type;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->alfa = $this->createStub(Angle::class);
        $this->beta = $this->getBeta();
        $this->setInputType();
    }

    abstract protected function getBeta(): (Angle&Stub)|float|int|string;

    abstract protected function getInputTypeClass(): string;

    /**
     * Set the `InputType` to be tested.
     * 
     * @throws Error if `getInputTypeClass()` return an invalid class.
     */
    protected function setInputType(): void
    {
        $input_type_class = $this->getInputTypeClass();
        $this->checkClassExists($input_type_class);
        if (! is_subclass_of($input_type_class, InputType::class))
            $this->throwNotAllowedClassError($input_type_class);
        $this->input_type = new $input_type_class($this->beta);
    }

    /**
     * Test the `InputType` return the correct strategy. This is a Parameterized Test.
     * 
     * @param string $comparison The comparison class.
     * @param string $strategy The strategy class this `InputType` should return.
     */
    protected function testInputType(string $comparison, string $strategy): void
    {
        $this->checkComparison($comparison);
        $this->checkStrategy($strategy);
        /** @var Comparison&Stub $comparison_stub */
        $comparison_stub = $this->createStub($comparison);
        $strategy_object = $this->input_type->getStrategyFor(
            $comparison_stub,
            $this->alfa
        );
        $this->assertInstanceOf($strategy, $strategy_object);
    }

    /**
     * Test the `InputType` throws an `Error` if `$comparison` is an invalid type.
     */
    protected function testInputTypeError(): void
    {
        // Arrange
        $beta = $this->getBeta();

        // Assert
        $this->expectException(Error::class);

        // Act
        $this->input_type->getStrategyFor(
            new UnknownComparison($this->alfa, $beta),
            $beta
        );
    }

    /**
     * Check the validity of the `$comparison` class.
     * 
     * @throws Error if `$comparison` is not a valid class.
     */
    #[Override]
    protected function checkComparison(string $comparison): void
    {
        $this->checkClassExists($comparison);
        if (! is_subclass_of($comparison, Comparison::class))
            $this->throwNotAllowedClassError($comparison);
    }

    /**
     * Check the validity of the `$strategy` class.
     * 
     * @throws Error if `$strategy` is not a valid class.
     */
    protected function checkStrategy(string $strategy): void
    {
        $this->checkClassExists($strategy);
        if (! is_subclass_of($strategy, Strategy::class))
            $this->throwNotAllowedClassError($strategy);
    }
}