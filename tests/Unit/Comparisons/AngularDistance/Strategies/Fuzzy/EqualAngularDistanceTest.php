<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Strategies\Fuzzy;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal as AngleFromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexagesimal as AngleFromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\Angle\SumBuilder;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal as AngularDistanceFromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexagesimal as AngularDistanceFromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\RelativeSum;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\Fuzzy\EqualAngularDistance as FuzzyEqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterOrEqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserOrEqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\AngularDistanceType;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\LesserOrEqual;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Random\Generator\AngularDistance as AngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngularDistance as NegativeAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngularDistance as PositiveAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeAngularDistance as NegativeAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveAngularDistance as PositiveAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Strategies\TestCase as StrategiesTestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(FuzzyEqualAngularDistance::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleFromSexadecimal::class)]
#[UsesClass(AngleFromSexagesimal::class)]
#[UsesClass(AngularDistance::class)]
#[UsesClass(AngularDistanceFromSexadecimal::class)]
#[UsesClass(AngularDistanceFromSexagesimal::class)]
#[UsesClass(AngularDistanceGenerator::class)]
#[UsesClass(AngularDistanceRange::class)]
#[UsesClass(AngularDistanceRange::class)]
#[UsesClass(AngularDistanceType::class)]
#[UsesClass(Comparison::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(EqualAngularDistance::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(Greater::class)]
#[UsesClass(GreaterAngle::class)]
#[UsesClass(GreaterAngularDistance::class)]
#[UsesClass(GreaterOrEqual::class)]
#[UsesClass(GreaterOrEqualAngle::class)]
#[UsesClass(GreaterOrEqualAngularDistance::class)]
#[UsesClass(LesserAngle::class)]
#[UsesClass(LesserAngularDistance::class)]
#[UsesClass(LesserAngularDistance::class)]
#[UsesClass(LesserOrEqual::class)]
#[UsesClass(LesserOrEqual::class)]
#[UsesClass(LesserOrEqualAngle::class)]
#[UsesClass(LesserOrEqualAngle::class)]
#[UsesClass(LesserOrEqualAngularDistance::class)]
#[UsesClass(LesserOrEqualAngularDistance::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(NegativeAngularDistanceGenerator::class)]
#[UsesClass(NegativeAngularDistanceGenerator::class)]
#[UsesClass(NegativeAngularDistanceValidator::class)]
#[UsesClass(NegativeAngularDistanceValidator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(PositiveAngularDistanceGenerator::class)]
#[UsesClass(PositiveAngularDistanceGenerator::class)]
#[UsesClass(PositiveAngularDistanceValidator::class)]
#[UsesClass(PositiveAngularDistanceValidator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(RelativeSum::class)]
#[UsesClass(RelativeSum::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesClass(SumBuilder::class)]
#[UsesClass(SumBuilder::class)]
#[UsesTrait(WithAngleFaker::class)]
#[UsesTrait(WithAngleFaker::class)]
class EqualAngularDistanceTest extends StrategiesTestCase
{
    protected string $comparison = '=';

    public function test_compare(): void
    {
        /**
         * Equal
         */
        // Arrange
        $delta = Angle::createFromValues(4);
        $beta = AngularDistance::createFromValues();
        $alfa = self::$faker->randomElement([
            $this->positiveRandomAngularDistance(max: 2),
            $this->negativeRandomAngularDistance(min: -2)
        ]);

        // Act & Assert
        $this->assertTrue(
            new FuzzyEqualAngularDistance($alfa, $beta, $delta)->compare(),
            $this->getFailMessageWithDelta($delta, $alfa, $beta)
        );

        /**
         * Different
         */
        // Arrange
        $alfa = self::$faker->randomElement([
            $this->negativeRandomAngularDistance(max: NextFloat::before(-2)),
            $this->positiveRandomAngularDistance(min: NextFloat::after(2))
        ]);

        // Act & Assert
        $this->assertFalse(
            new FuzzyEqualAngularDistance($alfa, $beta, $delta)->compare(),
            $this->getFailMessageWithDelta($delta, $alfa, $beta)
        );
    }
}