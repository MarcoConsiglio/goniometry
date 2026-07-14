<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexagesimal as AngleFromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexagesimal;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualInt as AngleEqualInt;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterAngle as AngleGreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserAngle as AngleLesserAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserInt as AngleLesserInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserOrEqualInt;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\Degrees as DegreesGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Strategies\TestCase as StrategiesTestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(LesserOrEqualInt::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngularDistance::class)]
#[UsesClass(AngularMeasure::class)]
#[UsesClass(AngleFromSexagesimal::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(FromSexagesimal::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(AngleEqualInt::class)]
#[UsesClass(AngleGreaterAngle::class)]
#[UsesClass(AngleLesserAngle::class)]
#[UsesClass(AngleLesserInt::class)]
#[UsesClass(EqualAngularDistance::class)]
#[UsesClass(EqualInt::class)]
#[UsesClass(LesserAngularDistance::class)]
#[UsesClass(LesserInt::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(DegreesGenerator::class)]
#[UsesClass(DegreesValidator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class LesserOrEqualIntTest extends StrategiesTestCase
{
    protected string $comparison = '≤';

    public function test_compare(): void
    {
        /**
         * Lesser
         */
        // Arrange
        $alfa = AngularDistance::createFromValues(
            degrees: $this->randomDegrees(max: 89)->value(),
            direction: Rotation::CLOCKWISE
        );
        $beta = $this->randomDegrees(min: 90, max: 180)->value();

        // Act & Assert
        $this->assertTrue(
            new LesserOrEqualInt($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Equal
         */
        // Arrange
        $rotation = self::$faker->randomElement([
            Rotation::COUNTER_CLOCKWISE,
            Rotation::CLOCKWISE
        ]);
        $alfa = AngularDistance::createFromValues(
            degrees: $degrees = $this->randomDegrees()->value(),
            direction: $rotation
        );
        $beta = $degrees * $rotation->value;

        // Act & Assert
        $this->assertTrue(
            new LesserOrEqualInt($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Greater
         */
        // Arrange
        $alfa = AngularDistance::createFromValues(
            $this->randomDegrees(min: 90, max: 180)->value()
        );
        $beta = $this->randomDegrees(max: 89)->value();

        // Act & Assert
        $this->assertFalse(
            new LesserOrEqualInt($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );
    }
}