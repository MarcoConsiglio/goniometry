<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Types;

use Error;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualFloat as AngleEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterFloat as AngleGreaterFloat;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualFloat as AngleLesserOrEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\DifferentFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterOrEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserOrEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\FloatType;
use MarcoConsiglio\Goniometry\Comparisons\ComparisonStrategy;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\InputType;
use MarcoConsiglio\Goniometry\Comparisons\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\LesserOrEqual;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Tests\Dummy\UnknownComparison;
use MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Angle\Types\InputTypeTestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\MockObject\Stub;

#[TestDox("The AngularDistance\Types\FloatType")]
#[CoversClass(FloatType::class)]
#[UsesClass(AngleEqualFloat::class)]
#[UsesClass(AngleGreaterFloat::class)]
#[UsesClass(AngleLesserOrEqualFloat::class)]
#[UsesClass(ComparisonStrategy::class)]
#[UsesClass(DifferentFloat::class)]
#[UsesClass(EqualFloat::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(GreaterFloat::class)]
#[UsesClass(GreaterOrEqualFloat::class)]
#[UsesClass(LesserFloat::class)]
#[UsesClass(LesserOrEqualFloat::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(RelativeSexadecimalValidator::class)]
#[UsesClass(SexadecimalRange::class)]
#[UsesTrait(WithAngleFaker::class)]
class FloatTypeTest extends InputTypeTestCase
{
    protected AngularDistance&Stub $alfa;

    protected float $beta;

    protected InputType $input_type;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->alfa = $this->createStub(AngularDistance::class);
        $this->beta = $this->randomSexadecimal();
        $this->input_type = new FloatType($this->beta);
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
        $this->assertInstanceOf(EqualFloat::class, $strategy);
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
        $this->assertInstanceOf(DifferentFloat::class, $strategy);
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
        $this->assertInstanceOf(GreaterFloat::class, $strategy);
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
        $this->assertInstanceOf(GreaterOrEqualFloat::class, $strategy);
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
        $this->assertInstanceOf(LesserFloat::class, $strategy);
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
        $this->assertInstanceOf(LesserOrEqualFloat::class, $strategy);        
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