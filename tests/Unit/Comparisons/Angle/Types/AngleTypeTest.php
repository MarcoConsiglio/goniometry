<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Types;

use Error;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\LesserOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\ComparisonStrategy;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\AngleType;
use MarcoConsiglio\Goniometry\Comparisons\InputType;
use MarcoConsiglio\Goniometry\Tests\Dummy\UnknownComparison;
use MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Angle\Types\InputTypeTestCase;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\Stub;

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