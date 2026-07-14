<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexagesimal as AngleFromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexagesimal;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualInt;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngularDistance as NegativeAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngularDistance as PositiveAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngularDistance as RelativeAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeAngularDistance as NegativeAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveAngularDistance as PositiveAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeAngularDistance as RelativeAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Strategies\TestCase as StrategiesTestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(EqualInt::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleFromSexagesimal::class)]
#[UsesClass(AngularDistance::class)]
#[UsesClass(AngularDistanceRange::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(EqualAngularDistance::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(FromSexagesimal::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(NegativeAngularDistanceGenerator::class)]
#[UsesClass(NegativeAngularDistanceValidator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveAngularDistanceGenerator::class)]
#[UsesClass(PositiveAngularDistanceValidator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(RelativeAngularDistanceGenerator::class)]
#[UsesClass(RelativeAngularDistanceValidator::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class EqualIntTest extends StrategiesTestCase
{
    protected string $comparison = '=';

    public function test_compare(): void
    {
        /**
         * Equal
         * Both angles positive
         */
        // Arrange
        $beta = $this->positiveRandomInteger(max: AngularDistance::MAX);
        $alfa = AngularDistance::createFromValues(
            degrees: $beta,
            direction: Rotation::COUNTER_CLOCKWISE
        );

        // Act & Assert
        $this->testCompare(EqualInt::class, $alfa, $beta);

        /**
         * Equal
         * Both angles negative
         */
        // Arrange
        $beta = $this->negativeRandomInteger(min: AngularDistance::MIN);
        $alfa = AngularDistance::createFromValues(
            degrees: $beta,
            direction: Rotation::CLOCKWISE
        );

        // Act & Assert
        $this->testCompare(EqualInt::class, $alfa, $beta);

        /**
         * Different
         * Both angles positive
         */
        $this->testCompare(
            EqualInt::class, 
            $this->positiveRandomAngularDistance(), 
            $this->positiveRandomInteger(max: AngularDistance::MAX),
            false
        );

        /**
         * Different
         * Both angles negative
         */
        $this->testCompare(
            EqualInt::class,
            $this->negativeRandomAngularDistance(),
            $this->negativeRandomInteger(min: AngularDistance::MIN),
            false
        );
    }
}