<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round;
use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterOrEqualFloat;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Random\Generator\AngularDistance as AngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngularDistance as RelativeAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeAngularDistance as RelativeAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Strategies\TestCase as StrategiesTestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(GreaterOrEqualFloat::class)]
#[UsesClass(AngularDistance::class)]
#[UsesClass(AngularDistanceGenerator::class)]
#[UsesClass(AngularDistanceRange::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(EqualFloat::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(GreaterFloat::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(RelativeAngularDistanceGenerator::class)]
#[UsesClass(RelativeAngularDistanceValidator::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(Round::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(Sexagesimal::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class GreaterOrEqualFloatTest extends StrategiesTestCase
{
    protected string $comparison = '≥';

    public function test_compare(): void
    {
        /**
         * Greater
         */
        // Arrange
        $precision = $this->randomPrecision();
        $alfa = $this->randomAngularDistance(min: 0, precision: $precision);
        $beta = $this->randomAngularDistance(max: NextFloat::beforeZero(), precision: $precision)->toFloat();

        // Act & Assert
        $this->assertTrue(
            new GreaterOrEqualFloat($alfa, $beta, $precision)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Equal
         */
        // Arrange
        $precision = $this->randomPrecision();
        $alfa = $this->randomAngularDistance(precision: $precision);
        $beta = $alfa->toFloat();

        // Act & Assert
        $this->assertTrue(
            new GreaterOrEqualFloat($alfa, $beta, $precision)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Lesser
         */
        // Arrange
        $precision = $this->randomPrecision();
        $alfa = $this->randomAngularDistance(max: NextFloat::beforeZero(), precision: $precision);
        $beta = $this->randomAngularDistance(min:0, precision: $precision)->toFloat();

        // Act & Assert
        $this->assertFalse(
            new GreaterOrEqualFloat($alfa, $beta, $precision)->compare(),
            $this->getFailMessage($alfa, $beta)
        );
    }
}