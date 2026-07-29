<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexagesimal as AngleFromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexagesimal;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserAngularDistance;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Random\Generator\AngularDistance as AngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Degrees as DegreesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\FloatGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Minutes as MinutesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngularDistance as NegativeAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngularDistance as PositiveAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Seconds as SecondsGenerator;
use MarcoConsiglio\Goniometry\Random\SecondsRange;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Minutes as MinutesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeAngularDistance as NegativeAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveAngularDistance as PositiveAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Seconds as SecondsValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;

use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Strategies\TestCase as StrategiesTestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(LesserAngularDistance::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleFromSexagesimal::class)]
#[UsesClass(AngularDistance::class)]
#[UsesClass(AngularDistanceGenerator::class)]
#[UsesClass(AngularDistanceRange::class)]
#[UsesClass(AngularMeasure::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(DegreesGenerator::class)]
#[UsesClass(DegreesValidator::class)]
#[UsesClass(FloatGenerator::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(FromSexagesimal::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(MinutesGenerator::class)]
#[UsesClass(MinutesValidator::class)]
#[UsesClass(NegativeAngularDistanceGenerator::class)]
#[UsesClass(NegativeAngularDistanceValidator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(PositiveAngularDistanceGenerator::class)]
#[UsesClass(PositiveAngularDistanceValidator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SecondsGenerator::class)]
#[UsesClass(SecondsRange::class)]
#[UsesClass(SecondsValidator::class)]
#[UsesClass(SexadecimalAngularDistance::class)]

#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class LesserAngularDistanceTest extends StrategiesTestCase
{
    protected string $comparison = '<';

    public function test_compare(): void
    {
        /**
         * Positive alfa is greater than negative alfa
         */
        // Arrange
        $alfa = $this->positiveRandomAngularDistance();
        $beta = $this->negativeRandomAngularDistance();

        // Act & Assert
        $this->assertFalse(
            new LesserAngularDistance($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Negative alfa is less than positive beta
         */
        // Arrange
        $alfa = $this->negativeRandomAngularDistance();
        $beta = $this->positiveRandomAngularDistance();

        // Act & Assert
        $this->assertTrue(
            new LesserAngularDistance($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Alfa degrees are greater than beta degrees.
         */
        // Arrange
        $alfa = AngularDistance::createFromValues($this->randomDegrees(min: 90, max: 179)->value());
        $beta = AngularDistance::createFromValues($this->randomDegrees(min: 0, max: 89)->value());

        // Act & Assert
        $this->assertFalse(
            new LesserAngularDistance($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Alfa degrees are less than beta degrees.
         */
        // Arrange
        $alfa = AngularDistance::createFromValues($this->randomDegrees(min: 0, max: 89)->value());
        $beta = AngularDistance::createFromValues($this->randomDegrees(min: 90, max: 179)->value());

        // Act & Assert
        $this->assertTrue(
            new LesserAngularDistance($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Alfa minutes are greater than beta minutes.
         */
        // Arrange
        $alfa = AngularDistance::createFromValues(minutes: $this->randomMinutes(min: 30)->value());
        $beta = AngularDistance::createFromValues(minutes: $this->randomMinutes(max: 29)->value());

        // Act & Assert
        $this->assertFalse(
            new LesserAngularDistance($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );   

        /**
         * Alfa minutes are less than beta minutes.
         */
        // Arrange
        $alfa = AngularDistance::createFromValues(minutes: $this->randomMinutes(max: 29)->value());
        $beta = AngularDistance::createFromValues(minutes: $this->randomMinutes(min: 30)->value());

        // Act & Assert
        $this->assertTrue(
            new LesserAngularDistance($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Alfa seconds are greater than beta seconds.
         */
        // Arrange
        $alfa = AngularDistance::createFromValues(seconds: $this->randomSeconds(min: 30)->value());
        $beta = AngularDistance::createFromValues(seconds: $this->randomSeconds(max: 29)->value());

        // Act & Assert
        $this->assertFalse(
            new LesserAngularDistance($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );
        
        /**
         * Alfa seconds are less than beta seconds.
         */
        // Arrange
        $alfa = AngularDistance::createFromValues(seconds: $this->randomSeconds(max: NextFloat::before(30))->value());
        $beta = AngularDistance::createFromValues(seconds: $this->randomSeconds(min: 30)->value());

        // Act & Assert
        $this->assertTrue(
            new LesserAngularDistance($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        ); 
    }

    public function test_negative_and_positive_180_degrees_are_equal(): void
    {
        // Arrange
        $precision = $this->randomPrecision();
        $alfa = AngularDistance::createFromValues(180, direction: Rotation::COUNTER_CLOCKWISE);
        $beta = AngularDistance::createFromValues(-180, direction: Rotation::CLOCKWISE);

        // Act & Assert
        $this->assertFalse(
            new LesserAngularDistance($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );
    }
}