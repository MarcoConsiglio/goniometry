<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Types;

use Error;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\DifferentAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterOrEqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserOrEqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\AngularDistanceType;
use MarcoConsiglio\Goniometry\Comparisons\ComparisonStrategy;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\InputType;
use MarcoConsiglio\Goniometry\Comparisons\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\LesserOrEqual;
use MarcoConsiglio\Goniometry\Tests\Dummy\UnknownComparison;
use MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Angle\Types\InputTypeTestCase;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\Stub;

#[TestDox("The AngularDistanceType ")]
#[CoversClass(AngularDistanceType::class)]
#[UsesClass(ComparisonStrategy::class)]
#[UsesClass(DifferentAngularDistance::class)]
#[UsesClass(EqualAngularDistance::class)]
#[UsesClass(GreaterAngularDistance::class)]
#[UsesClass(GreaterOrEqualAngle::class)]
#[UsesClass(GreaterOrEqualAngularDistance::class)]
#[UsesClass(LesserAngularDistance::class)]
#[UsesClass(LesserOrEqualAngularDistance::class)]
class AngularDistanceTypeTest extends InputTypeTestCase
{
    protected AngularDistance&Stub $alfa;

    protected AngularDistance&Stub $beta;

    protected InputType $input_type;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->alfa = $this->createStub(AngularDistance::class);
        $this->beta = $this->createStub(AngularDistance::class);
        $this->input_type = new AngularDistanceType($this->beta);
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
        $this->assertInstanceOf(EqualAngularDistance::class, $strategy);
    }

    #[TestDox("return the strategy for a Different comparison.")]
    public function test_different_strategy(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getStubComparison(Different::class),
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(DifferentAngularDistance::class, $strategy);
    }

    #[TestDox("return the strategy for a Greater comparison.")]
    public function test_greater_strategy(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getStubComparison(Greater::class),
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(GreaterAngularDistance::class, $strategy);
    }

    #[TestDox("return the strategy for a GreaterOrEqual comparison.")]
    public function test_greater_or_equal_strategy(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getStubComparison(GreaterOrEqual::class),
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(GreaterOrEqualAngularDistance::class, $strategy);
    }

    #[TestDox("return the strategy for a Lesser comparison.")]
    public function test_lesser_strategy(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getStubComparison(Lesser::class),
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(LesserAngularDistance::class, $strategy);
    }

    #[TestDox("return the strategy for a LesserOrEqual comparison.")]
    public function test_lesser_or_equal_strategy(): void
    {
        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getStubComparison(LesserOrEqual::class),
            $this->alfa
        );

        // Assert
        $this->assertInstanceOf(LesserOrEqualAngularDistance::class, $strategy);
    }

    #[TestDox("throws an error if there's no strategy.")]
    public function test_error(): void
    {
        // Assert
        $this->expectException(Error::class);

        // Act
        $strategy = $this->input_type->getStrategyFor(
            $this->getStubComparison(UnknownComparison::class),
            $this->alfa
        );        
    }
}