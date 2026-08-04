<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Angle\Types;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\Traits\CalcOrderForSexagesimals;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Different;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Greater;
use MarcoConsiglio\Goniometry\Comparisons\Angle\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\Angle\LesserOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentString;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualString;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualString;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterString;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualString;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserString;
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
use MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Angle\Types\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(StringType::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleGenerator::class)]
#[UsesClass(Comparison::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(DifferentString::class)]
#[UsesClass(EqualString::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(GreaterOrEqualString::class)]
#[UsesClass(GreaterString::class)]
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
#[UsesClass(SexadecimalAngle::class)]
#[UsesClass(SexadecimalRange::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(CalcOrderForSexagesimals::class)]
#[UsesTrait(WithAngleFaker::class)]
class StringTypeTest extends TestCase
{
    #[Override]
    protected function getBeta(): string
    {
        return (string) $this->randomAngle();
    }

    #[Override]
    protected function getInputTypeClass(): string
    {
        return StringType::class;
    }

    public function test_getStrategyFor(): void
    {
        $this->testInputType(Equal::class, EqualString::class);
        $this->testInputType(Different::class, DifferentString::class);
        $this->testInputType(Greater::class, GreaterString::class);
        $this->testInputType(GreaterOrEqual::class, GreaterOrEqualString::class);
        $this->testInputType(Lesser::class, LesserString::class);
        $this->testInputType(LesserOrEqual::class, LesserOrEqualString::class);
        $this->testInputTypeError();
    }
}