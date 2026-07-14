<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal as AngleFromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexagesimal as AngleFromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\Angle\FromString as AngleFromString;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal as AngularDistanceFromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexagesimal as AngularDistanceFromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromString as AngularDistanceFromString;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round;
use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualFloat as AngleEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualInt as AngleEqualInt;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualString as AngleEqualString;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserFloat as AngleLesserFloat;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserInt as AngleLesserInt;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualFloat as AngleLesserOrEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualInt as AngleLesserOrEqualInt;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualString as AngleLesserOrEqualString;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserString as AngleLesserString;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\AngleType;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\FloatType as AngleAndFloatType;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\IntType as AngleAndIntType;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\StringType as AngleAndStringType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualFloat as AngularDistanceEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualInt as AngularDistanceEqualInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualString as AngularDistanceEqualString;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserFloat as AngularDistanceLesserFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserInt as AngularDistanceLesserInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserOrEqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserOrEqualFloat as AngularDistanceLesserOrEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserOrEqualInt as AngularDistanceLesserOrEqualInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserOrEqualString as AngularDistanceLesserOrEqualString;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserString as AngularDistanceLesserString;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\AngularDistanceType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\FloatType as AngularDistanceFloatType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\IntType as AngularDistanceIntType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\StringType as AngularDistanceStringType;
use MarcoConsiglio\Goniometry\Comparisons\ComparisonStrategy;
use MarcoConsiglio\Goniometry\Comparisons\LesserOrEqual;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Random\Generator\AngularDistance as AngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngle as NegativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngle as PositiveAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngle as RelativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngularDistance as RelativeAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeAngularDistance as RelativeAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\TestCase as ComparisonsTestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(LesserOrEqual::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleAndFloatType::class)]
#[UsesClass(AngleAndIntType::class)]
#[UsesClass(AngleAndStringType::class)]
#[UsesClass(AngleEqualFloat::class)]
#[UsesClass(AngleEqualInt::class)]
#[UsesClass(AngleEqualString::class)]
#[UsesClass(AngleFromSexadecimal::class)]
#[UsesClass(AngleFromSexagesimal::class)]
#[UsesClass(AngleFromString::class)]
#[UsesClass(AngleLesserFloat::class)]
#[UsesClass(AngleLesserInt::class)]
#[UsesClass(AngleLesserOrEqualFloat::class)]
#[UsesClass(AngleLesserOrEqualInt::class)]
#[UsesClass(AngleLesserOrEqualString::class)]
#[UsesClass(AngleLesserString::class)]
#[UsesClass(AngleType::class)]
#[UsesClass(AngularDistance::class)]
#[UsesClass(AngularDistanceEqualFloat::class)]
#[UsesClass(AngularDistanceEqualInt::class)]
#[UsesClass(AngularDistanceEqualString::class)]
#[UsesClass(AngularDistanceFloatType::class)]
#[UsesClass(AngularDistanceFromSexadecimal::class)]
#[UsesClass(AngularDistanceFromSexagesimal::class)]
#[UsesClass(AngularDistanceFromString::class)]
#[UsesClass(AngularDistanceGenerator::class)]
#[UsesClass(AngularDistanceIntType::class)]
#[UsesClass(AngularDistanceLesserFloat::class)]
#[UsesClass(AngularDistanceLesserInt::class)]
#[UsesClass(AngularDistanceLesserOrEqualFloat::class)]
#[UsesClass(AngularDistanceLesserOrEqualInt::class)]
#[UsesClass(AngularDistanceLesserOrEqualString::class)]
#[UsesClass(AngularDistanceLesserString::class)]
#[UsesClass(AngularDistanceRange::class)]
#[UsesClass(AngularDistanceStringType::class)]
#[UsesClass(AngularDistanceType::class)]
#[UsesClass(ComparisonStrategy::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(EqualAngularDistance::class)]
#[UsesClass(LesserAngle::class)]
#[UsesClass(LesserAngularDistance::class)]
#[UsesClass(LesserOrEqualAngularDistance::class)]
#[UsesClass(LesserOrEqualAngle::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(NegativeAngleGenerator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveAngleGenerator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(RelativeAngleGenerator::class)]
#[UsesClass(RelativeAngularDistanceGenerator::class)]
#[UsesClass(RelativeAngularDistanceValidator::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(RelativeSexadecimalValidator::class)]
#[UsesClass(Round::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(Sexagesimal::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class LesserOrEqualTest extends ComparisonsTestCase
{
    public function test_compare(): void
    {
        $this->testComparison(LesserOrEqual::class);
    }
}