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
use MarcoConsiglio\Goniometry\Comparisons\Strategies\DifferentAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Types\AngleType;
use MarcoConsiglio\Goniometry\Comparisons\Types\InputType;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\Stub;

#[TestDox("The AngleType ")]
#[CoversClass(AngleType::class)]
#[UsesClass(Comparison::class)]
#[UsesClass(Equal::class)]
#[UsesClass(Different::class)]
#[UsesClass(Greater::class)]
#[UsesClass(GreaterOrEqual::class)]
#[UsesClass(Lesser::class)]
#[UsesClass(LesserOrEqual::class)]
#[UsesClass(ComparisonStrategy::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(DifferentAngle::class)]
#[UsesClass(GreaterAngle::class)]
#[UsesClass(GreaterOrEqualAngle::class)]
#[UsesClass(LesserAngle::class)]
#[UsesClass(LesserOrEqualAngle::class)]
class AngleTypeTest extends InputTypeTestCase
{
    protected Angle&Stub $alfa;

    protected Angle&Stub $beta;

    protected InputType $input_type;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->alfa = $this->createStub(Angle::class);
        $this->beta = $this->createStub(Angle::class);
        $this->input_type = new AngleType($this->beta);
    }

    #[TestDox("return the strategy for an Equal comparison.")]
    public function test_equal_strategy(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getStubComparison(Equal::class), 
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(EqualAngle::class, $strategy);
    }

    #[TestDox("return the strategy for a Different comparison.")]
    public function test_different_comparison(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getStubComparison(Different::class),
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(DifferentAngle::class, $strategy);
    }

    #[TestDox("return the strategy for a Greater comparison.")]
    public function test_greater_comparison(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getStubComparison(Greater::class),
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(GreaterAngle::class, $strategy);
    }

    #[TestDox("return the strategy for a GreaterOrEqual comparison.")]
    public function test_greater_or_equal_comparison(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getStubComparison(GreaterOrEqual::class),
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(GreaterOrEqualAngle::class, $strategy);
    }

    #[TestDox("return the strategy for a Lesser comparison.")]
    public function test_lesser_comparison(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getStubComparison(Lesser::class),
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(LesserAngle::class, $strategy);
    }

    #[TestDox("return the strategy for a LesserOrEqual comparison.")]
    public function test_lesser_or_equal_comparison(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getStubComparison(LesserOrEqual::class),
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(LesserOrEqualAngle::class, $strategy);
    }
}