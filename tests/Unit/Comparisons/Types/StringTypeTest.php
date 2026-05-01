<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Types;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\LesserOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\ComparisonStrategy;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\DifferentString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterOrEqualString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserOrEqualString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserString;
use MarcoConsiglio\Goniometry\Comparisons\Types\InputType;
use MarcoConsiglio\Goniometry\Comparisons\Types\StringType;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\Angle as AngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngle as NegativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngle as PositiveAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngle as RelativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\MockObject\Stub;

#[TestDox("The StringType ")]
#[CoversClass(StringType::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleGenerator::class)]
#[UsesClass(Comparison::class)]
#[UsesClass(ComparisonStrategy::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Different::class)]
#[UsesClass(DifferentString::class)]
#[UsesClass(Direction::class)]
#[UsesClass(Equal::class)]
#[UsesClass(EqualString::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Greater::class)]
#[UsesClass(GreaterOrEqual::class)]
#[UsesClass(GreaterOrEqualString::class)]
#[UsesClass(GreaterString::class)]
#[UsesClass(Lesser::class)]
#[UsesClass(LesserOrEqual::class)]
#[UsesClass(LesserOrEqualString::class)]
#[UsesClass(LesserString::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(NegativeAngleGenerator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveAngleGenerator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(RelativeAngleGenerator::class)]
#[UsesClass(RelativeSexadecimalValidator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexadecimalValidator::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class StringTypeTest extends InputTypeTestCase
{
    protected Angle&Stub $alfa;

    protected string $beta;

    protected InputType $input_type;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->alfa = $this->createStub(Angle::class);
        $this->beta = (string) $this->randomAngle();
        $this->input_type = new StringType($this->beta);
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
        $this->assertInstanceOf(EqualString::class, $strategy);
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
        $this->assertInstanceOf(DifferentString::class, $strategy);
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
        $this->assertInstanceOf(GreaterString::class, $strategy);
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
        $this->assertInstanceOf(GreaterOrEqualString::class, $strategy);
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
        $this->assertInstanceOf(LesserString::class, $strategy);
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
        $this->assertInstanceOf(LesserOrEqualString::class, $strategy);
    }
}