<?php
namespace MarcoConsiglio\Goniometry\Tests\Feature;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\AngularDistanceRadian;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal as AngleFromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexagesimal as AngleFromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\Angle\FromString as AngleFromString;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromRadian;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromString;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round;
use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\Generator\Angle as AngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\AngularDistance as AngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Degrees as DegreesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\FloatGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Minutes as MinutesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngularDistance as NegativeAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeRadian as NegativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngle as PositiveAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngularDistance as PositiveAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveRadian as PositiveRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Radian as RadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngle as RelativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngularDistance as RelativeAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeRadian as RelativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Seconds as SecondsGenerator;
use MarcoConsiglio\Goniometry\Random\SecondsRange;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Minutes as MinutesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeAngularDistance as NegativeAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveAngularDistance as PositiveAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeAngularDistance as RelativeAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeRadian as RelativeRadianRadian;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Seconds as SecondsValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(AngularDistance::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleFromSexagesimal::class)]
#[UsesClass(AngularDistanceRadian::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(DegreesGenerator::class)]
#[UsesClass(DegreesValidator::class)]
#[UsesClass(FloatGenerator::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(FromRadian::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(FromSexagesimal::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(MinutesGenerator::class)]
#[UsesClass(MinutesValidator::class)]
#[UsesClass(NegativeRadianGenerator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveRadianGenerator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(Radian::class)]
#[UsesClass(RadianGenerator::class)]
#[UsesClass(RelativeRadianGenerator::class)]
#[UsesClass(RelativeRadianRadian::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(RelativeSexadecimalValidator::class)]
#[UsesClass(Round::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SecondsGenerator::class)]
#[UsesClass(SecondsRange::class)]
#[UsesClass(SecondsValidator::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(Sexagesimal::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(AngleFromSexadecimal::class)]
#[UsesClass(FromString::class)]
#[UsesClass(AngleFromString::class)]
#[UsesClass(AngleGenerator::class)]
#[UsesClass(PositiveAngleGenerator::class)]
#[UsesClass(RelativeAngleGenerator::class)]
#[UsesClass(AngularDistanceGenerator::class)]
#[UsesClass(NegativeAngularDistanceGenerator::class)]
#[UsesClass(PositiveAngularDistanceGenerator::class)]
#[UsesClass(NegativeAngularDistanceValidator::class)]
#[UsesClass(PositiveAngularDistanceValidator::class)]
#[UsesClass(RelativeAngularDistanceGenerator::class)]
#[UsesClass(RelativeAngularDistanceValidator::class)]
#[UsesTrait(WithAngleFaker::class)]
class AngularDistanceTest extends TestCase
{
    public function test_create_from_values(): void
    {
        // Act
        $angle = AngularDistance::createFromValues(
            $this->randomDegrees()->value(),
            $this->randomMinutes()->value(),
            $this->randomSeconds()->value(),
            $this->randomDirection()
        );

        // Assert
        $this->assertInstanceOf(AngularDistance::class, $angle);
    }

    #[TestDox("can be created from a decimal number.")]
    public function test_create_from_decimal(): void
    {
        // Arrange
        $decimal = $this->randomSexadecimal(
            min: NextFloat::after(SexadecimalAngularDistance::MIN),
            max: NextFloat::before(SexadecimalAngularDistance::MAX),
            precision: 3
        );

        // Act
        $angle = AngularDistance::createFromDecimal($decimal);

        // Assert
        $this->assertInstanceOf(AngularDistance::class, $angle);
    }

    #[TestDox("can be created from a radian number.")]
    public function test_create_from_radian(): void
    {
        // Arrange
        $radian = $this->randomRadian(Radian::MIN / 2, Radian::MAX / 2);

        // Act
        $angle = AngularDistance::createFromRadian(new AngularDistanceRadian($radian->value));

        // Assert
        $this->assertInstanceOf(AngularDistance::class, $angle);
    }

    #[TestDox("can be created from a sexagesimal string.")]
    public function test_create_from_string(): void
    {
        // Arrange
        $string = (string) $this->randomAngle(precision: 3);

        // Act
        $angle = AngularDistance::createFromString($string);

        // Assert
        $this->assertInstanceOf(AngularDistance::class, $angle);
    }

    #[TestDox("can output degrees, minutes and seconds wrapped in a simple or associative array.")]
    public function test_get_angle_values_in_array(): void
    {
        // Arrange
        $alfa = AngularDistance::createFromValues(
            $degrees = $this->randomDegrees(max: 179)->value(), 
            $minutes = $this->randomMinutes()->value(), 
            $seconds = $this->randomSeconds()->value(1),
            $direction = $this->randomDirection()
        );
        $degrees *= $direction->value;

        // Act
        $simple_result = $alfa->getDegrees(precision: 1);
        $associative_result = $alfa->getDegrees(associative: true, precision: 1);

        // Assert
        $this->assertEquals($degrees,   $simple_result[0]);
        $this->assertEquals($minutes,   $simple_result[1]);
        $this->assertEquals($seconds,   $simple_result[2]);
        $this->assertEquals($degrees,   $associative_result["degrees"]);
        $this->assertEquals($minutes,   $associative_result["minutes"]);
        $this->assertEquals($seconds,   $associative_result["seconds"]);
    }

    #[TestDox("can toggle its direction.")]
    public function test_can_toggle_rotation_direction(): void
    {
        /**
         * With SexadecimalDegrees
         */
        // Arrange
        $failure_message_1 = "The angle should be counterclockwise but found the opposite.";
        $failure_message_2 = "The angle should be clockwise but found the opposite.";
        $alfa = $this->positiveRandomAngularDistance();
        $beta = $this->negativeRandomAngularDistance();

        // Act & Assert
        $this->assertDirection(
            $alfa->direction->opposite(), 
            $alfa->toggleDirection()->direction, 
            $failure_message_2
        );
        $this->assertDirection(
            $beta->direction->opposite(), 
            $beta->toggleDirection()->direction, 
            $failure_message_1
        );

        /**
         * With SexadecimalDegrees
         */
        // Arrange
        $gamma = AngularDistance::createFromValues(
            $this->randomDegrees(max: AngularDistance::MAX - 1)->value(), 
            direction: Direction::COUNTER_CLOCKWISE
        );
        $delta = AngularDistance::createFromValues(
            $this->randomDegrees(max: AngularDistance::MAX - 1)->value(), 
            direction: Direction::CLOCKWISE
        );

        // Act & Assert
        $this->assertSexadecimalDegrees(
            $gamma->toSexadecimalAngularDistance()->toggleDirection(),
            $gamma->toggleDirection()->toSexadecimalAngularDistance()
        );
        $this->assertSexadecimalDegrees(
            $delta->toSexadecimalAngularDistance()->toggleDirection(),
            $delta->toggleDirection()->toSexadecimalAngularDistance()
        );
    }

    #[TestDox("can be clockwise or negative.")]
    public function test_angle_is_clockwise(): void
    {
        // Arrange
        $alfa = $this->negativeRandomAngularDistance();

        // Act & assert
        $this->assertTrue($alfa->isClockwise(), "The angle is clockwise but found the opposite.");
        $this->assertFalse($alfa->isCounterClockwise(), "The angle is not counter clockwise but found the opposite.");
    }

    #[TestDox("can be counterclockwise or positive.")]
    public function test_angle_is_counterclockwise(): void
    {
        // Arrange
        $alfa = $this->positiveRandomAngularDistance();

        // Act & assert
        $this->assertTrue($alfa->isCounterClockwise(), "The angle is clockwise but found the opposite.");
        $this->assertFalse($alfa->isClockwise(), "The angle is not clockwise but found the opposite.");
    }

    #[TestDox("can be casted to SexagesimalDegrees.")]
    public function test_cast_angle_to_sexagesimal(): void
    {
        // Arrange
        $angle = $this->randomAngularDistance(precision: 3);

        // Act 
        $sexagesimal = $angle->toSexagesimalDegrees();

        // Assert
        $this->assertDegrees($angle->degrees, $sexagesimal->degrees);
        $this->assertMinutes($angle->minutes, $sexagesimal->minutes);
        $this->assertSeconds($angle->seconds, $sexagesimal->seconds);
        $this->assertDirection($angle->direction, $sexagesimal->direction);
    }
}