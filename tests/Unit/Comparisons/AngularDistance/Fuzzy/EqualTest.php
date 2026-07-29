<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Fuzzy;

use Error;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal as AngleFromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\Angle\SumBuilder;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal as AngularDistanceFromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\RelativeSum;
use MarcoConsiglio\Goniometry\Builders\Traits\CalcOrderForSexagesimals;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy\Types\AngleType as FuzzyAngleType;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\Fuzzy\EqualAngle as FuzzyEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy\Equal;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy\Types\AngularDistanceType as FuzzyAngularDistanceType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy\Types\InputType as FuzzyInputType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\Fuzzy\EqualAngularDistance as FuzzyEqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterOrEqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserOrEqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\AngularDistanceType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Greater;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\LesserOrEqual;
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
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeAngularDistance as RelativeAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngle;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;

use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(Equal::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleFromSexadecimal::class)]
#[UsesClass(AngleGenerator::class)]
#[UsesClass(AngularDistance::class)]
#[UsesClass(Comparison::class)]
#[UsesClass(AngularDistanceGenerator::class)]
#[UsesClass(AngularDistanceRange::class)]
#[UsesClass(AngularDistanceType::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(EqualAngularDistance::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(AngularDistanceFromSexadecimal::class)]
#[UsesClass(FuzzyInputType::class)]
#[UsesClass(FuzzyAngularDistanceType::class)]
#[UsesClass(FuzzyEqualAngularDistance::class)]
#[UsesClass(Greater::class)]
#[UsesClass(GreaterAngularDistance::class)]
#[UsesClass(GreaterOrEqual::class)]
#[UsesClass(GreaterOrEqualAngularDistance::class)]
#[UsesClass(LesserAngularDistance::class)]
#[UsesClass(LesserOrEqual::class)]
#[UsesClass(LesserOrEqualAngularDistance::class)]
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
#[UsesClass(SexadecimalRange::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexadecimalAngle::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesClass(SumBuilder::class)]
#[UsesTrait(WithAngleFaker::class)]
#[UsesTrait(CalcOrderForSexagesimals::class)]
class EqualTest extends TestCase
{
    public function test_compare_angular_distance(): void
    {
        // Arrange
        $alfa = $this->randomAngularDistance();
        $beta = $this->randomAngularDistance();
        $delta = $this->positiveRandomAngle();
        $comparison = new Equal($alfa, $beta, $delta);

        // Act & Assert
        $this->assertIsBool($comparison->compare());
    }
}