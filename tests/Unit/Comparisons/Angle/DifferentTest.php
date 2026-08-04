<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Angle;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\Angle\FromString;
use MarcoConsiglio\Goniometry\Builders\Traits\CalcOrderForSexagesimals;
use MarcoConsiglio\Goniometry\Casting\Radian\Round;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round as SexadecimalRound;
use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Different;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentFloat;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentInt;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentString;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualInt;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\AngleType;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\FloatType;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\IntType;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\StringType;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\Angle as AngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngle as NegativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngle as PositiveAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngle as RelativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngle;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(Different::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(FromSexagesimal::class)]
#[UsesClass(FromString::class)]
#[UsesTrait(CalcOrderForSexagesimals::class)]
#[UsesClass(Round::class)]
#[UsesClass(Sexagesimal::class)]
#[UsesClass(DifferentAngle::class)]
#[UsesClass(DifferentFloat::class)]
#[UsesClass(DifferentInt::class)]
#[UsesClass(DifferentString::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(EqualFloat::class)]
#[UsesClass(EqualInt::class)]
#[UsesClass(AngleType::class)]
#[UsesClass(FloatType::class)]
#[UsesClass(IntType::class)]
#[UsesClass(StringType::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(AngleGenerator::class)]
#[UsesClass(NegativeAngleGenerator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(PositiveAngleGenerator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(RelativeAngleGenerator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalAngle::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesClass(SexadecimalRound::class)]
#[UsesClass(SexadecimalRange::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(RelativeSexadecimalValidator::class)]
#[UsesTrait(WithAngleFaker::class)]
class DifferentTest extends TestCase
{
    public function test_compare(): void
    {
        $this->testComparison(Different::class);
    }
}