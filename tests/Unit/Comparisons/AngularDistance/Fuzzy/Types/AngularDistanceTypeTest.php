<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Fuzzy\Types;

use Error;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal as AngleFromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\Angle\SumBuilder;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal as AngularDistanceFromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\RelativeSum;
use MarcoConsiglio\Goniometry\Builders\Traits\CalcOrderForSexagesimals;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy\Equal;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy\Types\AngularDistanceType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\Fuzzy\EqualAngularDistance;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Random\Generator\Angle as AngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\AngularDistance as AngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngle as PositiveAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngularDistance as RelativeAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeAngularDistance as RelativeAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngle;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\Dummy\UnknownComparison;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(AngularDistanceType::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleFromSexadecimal::class)]
#[UsesClass(AngleGenerator::class)]
#[UsesClass(AngularDistance::class)]
#[UsesClass(AngularDistanceFromSexadecimal::class)]
#[UsesClass(AngularDistanceGenerator::class)]
#[UsesClass(AngularDistanceRange::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(EqualAngularDistance::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveAngleGenerator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(RelativeAngularDistanceGenerator::class)]
#[UsesClass(RelativeAngularDistanceValidator::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(RelativeSum::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalAngle::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesClass(SumBuilder::class)]
#[UsesTrait(CalcOrderForSexagesimals::class)]
#[UsesTrait(WithAngleFaker::class)]
class AngularDistanceTypeTest extends TestCase
{
    public function test_fuzzy_equal_strategy(): void
    {
        // Arrange
        $alfa = $this->randomAngularDistance();
        $beta = $this->randomAngularDistance();
        $delta = $this->positiveRandomAngle(max: 90);
        $input_type = new AngularDistanceType($beta, $delta);

        // Act
        $strategy = $input_type
            ->getStrategyFor(
                $this->createStub(Equal::class),
                $alfa
            );

        // Assert
        $this->assertInstanceOf(EqualAngularDistance::class, $strategy);
    }

    public function test_error(): void
    {
        // Assert
        $this->expectException(Error::class);

        // Arrange
        $alfa = $this->createStub(AngularDistance::class);
        $beta = $this->createStub(AngularDistance::class);
        $delta = $this->createStub(Angle::class);
        $input_type = new AngularDistanceType($beta, $delta);
        $comparison = new UnknownComparison($alfa, $beta);

        // Act
        $input_type
            ->getStrategyFor(
                $comparison,
                $this->createStub(AngularDistance::class)
            );
    }
}