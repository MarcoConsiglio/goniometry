<?php
namespace MarcoConsiglio\Goniometry\Tests\Feature;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\AbsoluteSum;
use MarcoConsiglio\Goniometry\Builders\FromRadian;
use MarcoConsiglio\Goniometry\Builders\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\FromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\FromString;
use MarcoConsiglio\Goniometry\Builders\RelativeSum;
use MarcoConsiglio\Goniometry\Builders\SumBuilder;
use MarcoConsiglio\Goniometry\Casting\Radian\Cast as CastToRadian;
use MarcoConsiglio\Goniometry\Casting\Radian\Round as RoundToRadian;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Cast as CastToSexadecimal;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round as RoundToSexadecimal;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\LesserOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\ComparisonStrategy;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\DifferentAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\DifferentFloat;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\DifferentInt;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\DifferentString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualInt;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\FloatComparisonStrategy;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterFloat;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterInt;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterOrEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterOrEqualInt;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterOrEqualString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserFloat;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserInt;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserOrEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserOrEqualInt;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserOrEqualString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserString;
use MarcoConsiglio\Goniometry\Comparisons\Types\AngleType;
use MarcoConsiglio\Goniometry\Comparisons\Types\FloatType;
use MarcoConsiglio\Goniometry\Comparisons\Types\IntType;
use MarcoConsiglio\Goniometry\Comparisons\Types\StringType;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\Generator\Degrees as DegreesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Minutes as MinutesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngle as NegativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeRadian as NegativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngle as PositiveAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveRadian;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Radian as RadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngle as RelativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeRadian as RelativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexagesimal as RelativeSexagesimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Seconds as SecondsGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Sexagesimal as SexagesimalGenerator;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\SecondsRange;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Minutes as MinutesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeRadian as RelativeRadianValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Seconds as SecondsValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[TestDox("The Angle class")]
#[CoversClass(Angle::class)]
#[UsesClass(AbsoluteSum::class)]
#[UsesClass(AngleType::class)]
#[UsesClass(CastToRadian::class)]
#[UsesClass(CastToSexadecimal::class)]
#[UsesClass(Comparison::class)]
#[UsesClass(ComparisonStrategy::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(DegreesGenerator::class)]
#[UsesClass(DegreesValidator::class)]
#[UsesClass(Different::class)]
#[UsesClass(DifferentAngle::class)]
#[UsesClass(DifferentFloat::class)]
#[UsesClass(DifferentInt::class)]
#[UsesClass(DifferentString::class)]
#[UsesClass(Direction::class)]
#[UsesClass(Equal::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(EqualFloat::class)]
#[UsesClass(EqualInt::class)]
#[UsesClass(EqualString::class)]
#[UsesClass(FloatComparisonStrategy::class)]
#[UsesClass(FloatType::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(FromRadian::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(FromSexagesimal::class)]
#[UsesClass(FromString::class)]
#[UsesClass(Greater::class)]
#[UsesClass(GreaterAngle::class)]
#[UsesClass(GreaterFloat::class)]
#[UsesClass(GreaterInt::class)]
#[UsesClass(GreaterOrEqual::class)]
#[UsesClass(GreaterOrEqualAngle::class)]
#[UsesClass(GreaterOrEqualFloat::class)]
#[UsesClass(GreaterOrEqualInt::class)]
#[UsesClass(GreaterOrEqualString::class)]
#[UsesClass(GreaterString::class)]
#[UsesClass(IntType::class)]
#[UsesClass(Lesser::class)]
#[UsesClass(LesserAngle::class)]
#[UsesClass(LesserFloat::class)]
#[UsesClass(LesserInt::class)]
#[UsesClass(LesserOrEqual::class)]
#[UsesClass(LesserOrEqualAngle::class)]
#[UsesClass(LesserOrEqualFloat::class)]
#[UsesClass(LesserOrEqualInt::class)]
#[UsesClass(LesserOrEqualString::class)]
#[UsesClass(LesserString::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(MinutesGenerator::class)]
#[UsesClass(MinutesValidator::class)]
#[UsesClass(NegativeAngleGenerator::class)]
#[UsesClass(NegativeRadianGenerator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveAngleGenerator::class)]
#[UsesClass(PositiveRadian::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(Radian::class)]
#[UsesClass(RadianGenerator::class)]
#[UsesClass(RadianRange::class)]
#[UsesClass(RelativeAngleGenerator::class)]
#[UsesClass(RelativeRadianGenerator::class)]
#[UsesClass(RelativeRadianValidator::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(RelativeSexadecimalValidator::class)]
#[UsesClass(RelativeSexagesimalGenerator::class)]
#[UsesClass(RelativeSexagesimalGenerator::class)]
#[UsesClass(RelativeSum::class)]
#[UsesClass(RoundToRadian::class)]
#[UsesClass(RoundToSexadecimal::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SecondsGenerator::class)]
#[UsesClass(SecondsRange::class)]
#[UsesClass(SecondsValidator::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexadecimalValidator::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesClass(SexagesimalGenerator::class)]
#[UsesClass(StringType::class)]
#[UsesClass(SumBuilder::class)]
#[UsesTrait(WithAngleFaker::class)]
class AngleTest extends TestCase
{    
    #[TestDox('has "degrees" property which is of type Degrees.')]
    public function test_degrees_property(): void
    {
        // Arrange
        $degrees = $this->randomDegrees()->value();
        $angle = Angle::createFromValues($degrees);

        // Act & Assert
        $this->assertEquals($degrees, $angle->degrees->value());
    }

    #[TestDox('has "minutes" property which is of type Minutes.')]
    public function test_minutes_property(): void
    {
        $minutes = $this->randomMinutes()->value();
        $angle = Angle::createFromValues(minutes: $minutes);

        // Act & Assert
        $this->assertEquals($minutes, $angle->minutes->value());
    }

    #[TestDox('has "seconds" property which is of type Seconds.')]
    public function test_seconds_property(): void
    {
        $seconds = $this->randomSeconds(precision: 1)->value();
        $angle = Angle::createFromValues(seconds: $seconds);

        // Act & Assert
        $this->assertEquals(
            $seconds,
            $angle->seconds->value()
        );
    }

    #[TestDox("had read-only property \"direction\" which is of type Direction.")]
    public function test_direction_property(): void
    {
        // Arrange
        $direction = $this->randomDirection();
        $angle = Angle::createFromValues(degrees: 1, direction: $direction);

        // Act & Assert
        $this->assertEquals($direction, $angle->direction);
    }

    #[TestDox("can be created from separated values for degrees, minutes, seconds and direction.")]
    public function test_create_from_values()
    {
        // Arrange
        $sexagesimal = $this->randomSexagesimal();

        // Act
        $angle = Angle::createFromValues(
            $sexagesimal->degrees->value(), 
            $sexagesimal->minutes->value(), 
            $sexagesimal->seconds->value(), 
            $sexagesimal->direction
        );

        // Assert
        $this->assertDegrees($sexagesimal->degrees, $angle->degrees);
        $this->assertMinutes($sexagesimal->minutes, $angle->minutes);
        $this->assertSeconds(
            $sexagesimal->seconds,
            $angle->seconds,
            precision: 1
        );
        $this->assertDirection($sexagesimal->direction, $angle->direction);
    }

    #[TestDox("can be created from a textual representation.")]
    public function test_create_from_string()
    {
        // Arrange
        $degrees = $this->randomDegrees();
        $minutes = $this->randomMinutes();
        $seconds = $this->randomSeconds(precision: 1);
        $direction = $this->randomDirection();
        $sign = $direction == Direction::CLOCKWISE ? '-' : '';
        $text = "{$sign}{$degrees} {$minutes} {$seconds}";

        // Act
        $angle = Angle::createFromString($text);

        // Act
        $this->assertDegrees($degrees, $angle->degrees, $text);
        $this->assertMinutes($minutes, $angle->minutes, $text);
        $this->assertSeconds($seconds, $angle->seconds, 1, $text);
        $this->assertDirection($direction, $angle->direction, $text);
    }

    #[TestDox("can be created from a decimal number.")]
    public function test_create_from_decimal()
    {
        // Arrange
        $decimal = $this->randomSexadecimal(precision: 1);

        // Act
        $angle = Angle::createFromDecimal($decimal);

        $this->assertEquals(
            $decimal, 
            $angle->toFloat(1)
        );
    }

    #[TestDox("can be created from a radian number.")]
    public function test_create_from_radiant()
    {
        // Arrange
        $radian = $this->randomRadian(precision: 6);

        // Act
        $angle = Angle::createFromRadian($radian);

        // Assert
        $this->assertEquals(
            $radian->value(), 
            $angle->toRadian()
        );
    }

    #[TestDox("can output degrees, minutes and seconds wrapped in a simple or associative array.")]
    public function test_get_angle_values_in_array()
    {
        // Arrange
        /** @var \MarcoConsiglio\Goniometry\Angle&\PHPUnit\Framework\MockObject\MockObject $alfa */
        $alfa = Angle::createFromValues(
            $degrees = $this->randomDegrees()->value(), 
            $minutes = $this->randomMinutes()->value(), 
            $seconds = $this->randomSeconds(precision: 1)->value(),
            $direction = $this->randomDirection()
        );
        /** @var Direction $direction */
        $degrees *= $direction->value;

        // Act
        $simple_result = $alfa->getDegrees();
        $associative_result = $alfa->getDegrees(associative: true);

        // Assert
        $this->assertEquals($degrees,   $simple_result[0]);
        $this->assertEquals($minutes,   $simple_result[1]);
        $this->assertEquals(
            $this->safeRound($seconds),   
            $this->safeRound($simple_result[2])
        );
        $this->assertEquals($degrees,   $associative_result["degrees"]);
        $this->assertEquals($minutes,   $associative_result["minutes"]);
        $this->assertEquals(
            $this->safeRound($seconds),   
            $this->safeRound($associative_result["seconds"])
        );
    }

    #[TestDox("can be casted to string.")]
    public function test_cast_angle_to_string()
    {
        // Arrange
        $alfa = $this->randomAngle(precision: 3);
        $sign = $alfa->direction == Direction::COUNTER_CLOCKWISE ? "" : "-";
        $degrees = $alfa->degrees;
        $minutes = $alfa->minutes;
        $seconds = $alfa->seconds;
        
        // Act & Assert
        $this->assertEquals("{$sign}{$degrees} {$minutes} {$seconds}", (string) $alfa);
    }

    #[TestDox("can be casted to float.")]
    public function test_cast_to_float()
    {
        // Arrange
        $angle = Angle::createFromValues(
            $this->randomDegrees()->value(),
            $this->randomMinutes()->value(),
            $this->randomSeconds()->value(),
            $this->randomDirection()
        );

        // Act
        $actual = $angle->toFloat();

        // Assert
        $this->assertIsFloat($actual);
    }

    #[TestDox("can be casted to radian.")]
    public function test_cast_to_radian()
    {
        // Arrange
        $angle = $this->randomAngle();

        // Act & Assert
        $this->assertIsFloat($angle->toRadian());
    }

    #[TestDox("can be clockwise or negative.")]
    public function test_angle_is_clockwise()
    {
        // Arrange
        $alfa = $this->negativeRandomAngle();

        // Act & assert
        $this->assertTrue($alfa->isClockwise(), "The angle is clockwise but found the opposite.");
        $this->assertFalse($alfa->isCounterClockwise(), "The angle is not counter clockwise but found the opposite.");
    }

    #[TestDox("can be counterclockwise or positive.")]
    public function test_angle_is_counterclockwise()
    {
        // Arrange
        $alfa = $this->positiveRandomAngle();

        // Act & assert
        $this->assertTrue($alfa->isCounterClockwise(), "The angle is clockwise but found the opposite.");
        $this->assertFalse($alfa->isClockwise(), "The angle is not clockwise but found the opposite.");
    }

    #[TestDox("can toggle its direction.")]
    public function test_can_toggle_rotation_direction()
    {
        // Arrange
        $alfa = $this->positiveRandomAngle();
        $beta = $this->negativeRandomAngle();

        // Act
        $alfa_opposite = $alfa->toggleDirection(); /* From positive to negative */
        $beta_opposite = $beta->toggleDirection(); /* From negative to positive */

        // Assert
        $failure_message_1 = "The angle should be counterclockwise but found the opposite.";
        $failure_message_2 = "The angle should be clockwise but found the opposite.";
        $this->assertEquals(Direction::CLOCKWISE, $alfa_opposite->direction, $failure_message_2);
        $this->assertEquals(
            $alfa->toSexadecimalDegrees()->value->mul(-1)->toFloat(), 
            $alfa_opposite->toSexadecimalDegrees()->value()
        );
        $this->assertEquals(Direction::COUNTER_CLOCKWISE, $beta_opposite->direction, $failure_message_1);
        $this->assertEquals(
            $beta->toSexadecimalDegrees()->value->mul(-1)->toFloat(),
            $beta_opposite->toSexadecimalDegrees()->value()
        );
    }

    #[TestDox("can be equal compared against an int, float, string or Angle.")]
    public function test_equal_comparison()
    {
        // Arrange
        $alfa = $this->randomAngle();
        $int_beta = $this->randomDegrees()->value();
        $string_beta = (string) $this->randomAngle();
        $float_beta = $this->randomAngle()->toFloat();
        $angle_beta = $this->randomAngle();

        // Act & Assert
        $this->assertIsBool($alfa->eq($int_beta));
        $this->assertIsBool($alfa->eq($string_beta));
        $this->assertIsBool($alfa->eq($float_beta));
        $this->assertIsBool($alfa->eq($angle_beta));
    }

    #[TestDox("can be different compared against an int, float, string or Angle.")]
    public function test_different_comparison(): void
    {
        // Arrange
        $alfa = $this->randomAngle();
        $int_beta = $this->randomDegrees()->value();
        $string_beta = (string) $this->randomAngle();
        $float_beta = $this->randomAngle()->toFloat();
        $angle_beta = $this->randomAngle();

        // Act & Assert
        $this->assertIsBool($alfa->not($int_beta));
        $this->assertIsBool($alfa->not($string_beta));
        $this->assertIsBool($alfa->not($float_beta));
        $this->assertIsBool($alfa->not($angle_beta));
    }

    #[TestDox("can be greater compared against an int, float, string or Angle.")]
    public function test_greater_comparison(): void
    {
        // Arrange
        $alfa = $this->randomAngle();
        $int_beta = $this->randomDegrees()->value();
        $string_beta = (string) $this->randomAngle();
        $float_beta = $this->randomAngle()->toFloat();
        $angle_beta = $this->randomAngle();

        // Act & Assert
        $this->assertIsBool($alfa->gt($int_beta));
        $this->assertIsBool($alfa->gt($string_beta));
        $this->assertIsBool($alfa->gt($float_beta));
        $this->assertIsBool($alfa->gt($angle_beta));
    }

    #[TestDox("can be greater or equal compared against an int, float, string or Angle.")]
    public function test_greater_or_equal_comparison(): void
    {
        // Arrange
        $alfa = $this->randomAngle();
        $int_beta = $this->randomDegrees()->value();
        $string_beta = (string) $this->randomAngle();
        $float_beta = $this->randomAngle()->toFloat();
        $angle_beta = $this->randomAngle();

        // Act & Assert
        $this->assertIsBool($alfa->gte($int_beta));
        $this->assertIsBool($alfa->gte($string_beta));
        $this->assertIsBool($alfa->gte($float_beta));
        $this->assertIsBool($alfa->gte($angle_beta));
    }

    #[TestDox("can be lesser compared against an int, float, string or Angle.")]
    public function test_lesser_comparison(): void
    {
        // Arrange
        $alfa = $this->randomAngle();
        $int_beta = $this->randomDegrees()->value();
        $string_beta = (string) $this->randomAngle();
        $float_beta = $this->randomAngle()->toFloat();
        $angle_beta = $this->randomAngle();

        // Act & Assert
        $this->assertIsBool($alfa->lt($int_beta));
        $this->assertIsBool($alfa->lt($string_beta));
        $this->assertIsBool($alfa->lt($float_beta));
        $this->assertIsBool($alfa->lt($angle_beta));       
    }

    #[TestDox("can be lesser or equal compared against an int, float, string or Angle.")]
    public function test_lesser_or_equal_comparison(): void
    {
        // Arrange
        $alfa = $this->randomAngle();
        $int_beta = $this->randomDegrees()->value();
        $string_beta = (string) $this->randomAngle();
        $float_beta = $this->randomAngle()->toFloat();
        $angle_beta = $this->randomAngle();

        // Act & Assert
        $this->assertIsBool($alfa->lte($int_beta));
        $this->assertIsBool($alfa->lte($string_beta));
        $this->assertIsBool($alfa->lte($float_beta));
        $this->assertIsBool($alfa->lte($angle_beta));      
    }

    #[TestDox("can sum two angles obtaining a relative result.")]
    public function test_can_sum_two_angles_and_return_relative_result()
    {
        // Arrange
        $alfa = $this->randomAngle();
        $beta = $this->randomAngle();

        // Act
        $gamma = Angle::sum($alfa, $beta);

        // Assert
        $this->assertInstanceOf(Angle::class, $gamma, $this->methodMustReturn(
            Angle::class, "sum", Angle::class
        ));
    }

    #[TestDox("can sum two angles obtaining an absolute result.")]
    public function test_can_sum_two_angles_and_return_absolute_result()
    {
        // Arrange
        $alfa = $this->randomAngle();
        $beta = $this->randomAngle();

        // Act
        $gamma = Angle::absSum($alfa, $beta);

        // Assert
        $this->assertInstanceOf(Angle::class, $gamma, $this->methodMustReturn(
            Angle::class, "absSum", Angle::class
        ));
        $this->assertDirection(Direction::COUNTER_CLOCKWISE, $gamma->direction, 
            Angle::class."absSum() method must always return a positive angle."
        );
    }
}