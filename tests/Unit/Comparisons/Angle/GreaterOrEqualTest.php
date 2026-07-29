<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Angle;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\Angle\FromString;
use MarcoConsiglio\Goniometry\Builders\Traits\CalcOrderForSexagesimals;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round;
use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\Comparisons\Angle\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualInt;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualString;
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

#[CoversClass(GreaterOrEqual::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleGenerator::class)]
#[UsesClass(AngleType::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(FloatType::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(FromSexagesimal::class)]
#[UsesClass(FromString::class)]
#[UsesClass(GreaterAngle::class)]
#[UsesClass(GreaterOrEqualAngle::class)]
#[UsesClass(GreaterOrEqualFloat::class)]
#[UsesClass(GreaterOrEqualInt::class)]
#[UsesClass(GreaterOrEqualString::class)]
#[UsesClass(IntType::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(NegativeAngleGenerator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveAngleGenerator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(RelativeAngleGenerator::class)]
#[UsesClass(RelativeSexadecimalValidator::class)]
#[UsesClass(Round::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalAngle::class)]
#[UsesClass(SexadecimalRange::class)]
#[UsesClass(Sexagesimal::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesClass(StringType::class)]
#[UsesTrait(CalcOrderForSexagesimals::class)]
#[UsesTrait(WithAngleFaker::class)]
class GreaterOrEqualTest extends TestCase
{
    public function test_compare(): void
    {
        $this->testComparison(GreaterOrEqual::class);
    }
}