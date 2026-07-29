<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Types;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\Traits\CalcOrderForSexagesimals;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserOrEqualString;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\DifferentString;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualString;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterOrEqualString;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterString;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserString;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\StringType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Different;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Equal;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Greater;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\LesserOrEqual;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngularDistance as RelativeAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeAngularDistance as RelativeAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(StringType::class)]
#[UsesClass(AngularDistance::class)]
#[UsesClass(AngularDistance::class)]
#[UsesClass(AngularDistanceRange::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(DifferentString::class)]
#[UsesClass(EqualString::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(GreaterOrEqualString::class)]
#[UsesClass(GreaterString::class)]
#[UsesClass(LesserOrEqualString::class)]
#[UsesClass(LesserString::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(RelativeAngularDistanceGenerator::class)]
#[UsesClass(RelativeAngularDistanceValidator::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(CalcOrderForSexagesimals::class)]
#[UsesTrait(WithAngleFaker::class)]
class StringTypeTest extends TestCase
{
    #[Override]
    protected function getBeta(): string
    {
        return (string) $this->randomAngularDistance();
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
    }
}