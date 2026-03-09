<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Types;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\LesserOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\ComparisonStrategy;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\DifferentFloat;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterFloat;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterOrEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserFloat;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserOrEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\Types\FloatType;
use MarcoConsiglio\Goniometry\Comparisons\Types\InputType;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;


#[TestDox("The FloatType ")]
#[CoversClass(FloatType::class)]
#[UsesClass(Comparison::class)]
#[UsesClass(Equal::class)]
#[UsesClass(Different::class)]
#[UsesClass(Greater::class)]
#[UsesClass(GreaterOrEqual::class)]
#[UsesClass(Lesser::class)]
#[UsesClass(LesserOrEqual::class)]
#[UsesClass(ComparisonStrategy::class)]
#[UsesClass(EqualFloat::class)]
#[UsesClass(DifferentFloat::class)]
#[UsesClass(GreaterFloat::class)]
#[UsesClass(GreaterOrEqualFloat::class)]
#[UsesClass(LesserFloat::class)]
#[UsesClass(LesserOrEqualFloat::class)]
class FloatTypeTest extends InputTypeTestCase
{
    protected Angle&MockObject $alfa;

    protected float $beta;

    protected InputType $input_type;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->alfa = $this->getMockedAngle();
        $this->beta = $this->randomSexadecimal();
        $this->input_type = new FloatType($this->beta);
    }

    #[TestDox("return the strategy for an Equal comparison.")]
    public function test_equal_strategy(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getMockedComparison(Equal::class), 
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(EqualFloat::class, $strategy);
    }

    #[TestDox("return the strategy for a Different comparison.")]
    public function test_different_comparison(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getMockedComparison(Different::class),
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(DifferentFloat::class, $strategy);
    }

    #[TestDox("return the strategy for a Greater comparison.")]
    public function test_greater_comparison(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getMockedComparison(Greater::class),
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(GreaterFloat::class, $strategy);
    }

    #[TestDox("return the strategy for a GreaterOrEqual comparison.")]
    public function test_greater_or_equal_comparison(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getMockedComparison(GreaterOrEqual::class),
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(GreaterOrEqualFloat::class, $strategy);
    }

    #[TestDox("return the strategy for a Lesser comparison.")]
    public function test_lesser_comparison(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getMockedComparison(Lesser::class),
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(LesserFloat::class, $strategy);
    }

    #[TestDox("return the strategy for a LesserOrEqual comparison.")]
    public function test_lesser_or_equal_comparison(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getMockedComparison(LesserOrEqual::class),
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(LesserOrEqualFloat::class, $strategy);
    }

    /**
     * Return the mocked alfa Angle.
     */
    protected function getMockedAlfa(): Angle&MockObject
    {
        return $this->alfa;
    }

    /**
     * Return the mocked beta Angle.
     */
    protected function getMockedBeta(): float
    {
        return $this->beta;
    }
}