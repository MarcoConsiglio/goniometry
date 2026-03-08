<?php
namespace MarcoConsiglio\Goniometry\Tests\Feature;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromAnglesToAbsoluteSum;
use MarcoConsiglio\Goniometry\Builders\FromAnglesToRelativeSum;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Builders\FromRadian;
use MarcoConsiglio\Goniometry\Builders\FromString;
use MarcoConsiglio\Goniometry\Builders\SumBuilder;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use RoundingMode;

#[TestDox("The Angle class")]
#[CoversClass(Angle::class)]
#[UsesClass(FromAnglesToAbsoluteSum::class)]
#[UsesClass(FromAnglesToRelativeSum::class)]
#[UsesClass(FromDegrees::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(FromString::class)]
#[UsesClass(FromRadian::class)]
#[UsesClass(SumBuilder::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class AngleTest extends TestCase
{
    #[TestDox('has "degrees" property which is of type Degrees.')]
    public function test_degrees_property(): void
    {
        // Arrange
        $degrees = $this->randomDegrees();
        $alfa = Angle::createFromValues($degrees);

        // Act & Assert
        $this->assertTrue($alfa->degrees->value->eq($degrees), $this->propertyFail("degrees"));
    }

    #[TestDox('has "minutes" property which is of type Minutes.')]
    public function test_minutes_property(): void
    {
        $minutes = $this->randomMinutes();
        $alfa = Angle::createFromValues(minutes: $minutes);

        // Act & Assert
        $this->assertTrue($alfa->minutes->value->eq($minutes), $this->propertyFail("minutes"));
    }

    #[TestDox('has "seconds" property which is of type Minutes.')]
    public function test_seconds_property(): void
    {
        $seconds = $this->randomSeconds();
        $alfa = Angle::createFromValues(seconds: $seconds);

        // Act & Assert
        $this->assertTrue($alfa->seconds->value->eq(Number::string($seconds)), $this->propertyFail("minutes"));
    }

    #[TestDox("had read-only property \"direction\" which is of type Direction.")]
    public function test_direction_property(): void
    {
        // Arrange
        $direction = $this->randomDirection();
        $alfa = Angle::createFromValues(degrees: 1, direction: $direction);

        // Act & Assert
        $this->assertEquals($direction, $alfa->direction, $this->getPropertyError("direction"));
    }

    #[TestDox("can be created from separated values for degrees, minutes, seconds and direction.")]
    public function test_create_from_values()
    {
        // Arrange
        [$degrees, $minutes, $seconds, $direction] = 
            $this->randomSexagesimal();

        // Act
        $angle = Angle::createFromValues($degrees, $minutes, $seconds, $direction);

        // Assert
        $this->assertAngleHasValues($angle, [
            "degrees" => $degrees * $direction->value,
            "minutes" => $minutes,
            "seconds" => $seconds,
        ]);
    }

    #[TestDox("can be created from a textual representation.")]
    public function test_create_from_string()
    {
        // Arrange
        $degrees = $this->randomDegrees();
        $minutes = $this->randomMinutes();
        $seconds = Number::string($this->randomSeconds());
        $direction = $this->faker->randomElement(["-", ""]);
        $text = "{$direction}{$degrees}° {$minutes}' {$seconds}\"";

        // Act
        $angle = Angle::createFromString($text);

        // Act
        $this->assertAngleHasValues($angle, [
            "degrees" => $direction == "-" ? -$degrees : $degrees,
            "minutes" => $minutes,
            "seconds" => $seconds,
        ]);
    }

    #[TestDox("can be created from a decimal number.")]
    public function test_create_from_decimal()
    {
        // Arrange
        $precision = PHP_FLOAT_DIG;
        $decimal = $this->faker->randomFloat(
            $precision,             /* Max available precision */ 
            -Angle::MAX_DEGREES,    /* -360° */
            Angle::MAX_DEGREES      /* +360° */
        );

        // Act
        $angle = Angle::createFromDecimal($decimal);

        $this->assertEquals(
            $decimal, 
            $angle->toFloat()
        );
    }

    #[TestDox("can be created from a radian number.")]
    public function test_create_from_radiant()
    {
        // Arrange
        $radian = $this->randomFloat(max: Angle::MAX_RADIAN - PHP_FLOAT_MIN);

        // Act
        $angle = Angle::createFromRadian($radian);

        // Assert
        $this->assertEquals($radian, $angle->toRadian());
    }

    #[TestDox("can output degrees, minutes and seconds wrapped in a simple or associative array.")]
    public function test_get_angle_values_in_array()
    {
        // Arrange
        /** @var \MarcoConsiglio\Goniometry\Angle&\PHPUnit\Framework\MockObject\MockObject $alfa */
        $alfa = Angle::createFromValues(
            $degrees = $this->faker->numberBetween(0, 360), 
            $minutes = $this->faker->numberBetween(0, 59), 
            $seconds = $this->faker->randomFloat(1, 0, 59.9),
            $direction = $this->faker->randomElement([Direction::CLOCKWISE, Direction::COUNTER_CLOCKWISE])
        );
        /** @var Direction $direction */
        $degrees *= $direction->value;

        // Act
        $simple_result = $alfa->getDegrees();
        $associative_result = $alfa->getDegrees(associative: true);

        // Assert
        $failure_message_1 = "Can't get angle values as a simple array.";
        $failure_message_2 = "Can't get angle values as an associative array.";
        $this->assertEquals($degrees,   $simple_result[0],              $failure_message_1);
        $this->assertEquals($minutes,   $simple_result[1],              $failure_message_1);
        $this->assertEquals($seconds,   $simple_result[2],              $failure_message_1);
        $this->assertEquals($degrees,   $associative_result["degrees"], $failure_message_2);
        $this->assertEquals($minutes,   $associative_result["minutes"], $failure_message_2);
        $this->assertEquals($seconds,   $associative_result["seconds"], $failure_message_2);
    }

    #[TestDox("can be printed in a positive or negative textual representation.")]
    public function test_cast_angle_to_string()
    {
        // Arrange
        $alfa = Angle::createFromValues(1, 2, 3.141592653589793);
        $expected_alfa_string = "1° 2' 3.141592653589793\"";
        $beta = clone $alfa;
        $negative_beta = $beta->toggleDirection();
        $expected_beta_string = "-" . $expected_alfa_string;

        // Act & Assert
        $this->assertEquals($expected_alfa_string, (string) $alfa, $this->getCastError("string"));
        $this->assertEquals($expected_beta_string, (string) $negative_beta, $this->getCastError("string"));
    }

    #[TestDox("can be casted to decimal.")]
    public function test_cast_to_decimal()
    {
        $this->testCasttoFloat();
        $this->testCasttoFloat(0);
        $this->testCasttoFloat($this->faker->numberBetween(1, PHP_FLOAT_DIG - 3));
        $this->testCasttoFloat(PHP_FLOAT_DIG - 2);
        $this->testCasttoFloat(PHP_FLOAT_DIG);

        /**
         * Other builders than FromDecimal.
         * 
         * This test is not significant as the expectation is calculated from the SUT.
         */
        // Arrange
        $precision = $this->faker->numberBetween(0, PHP_FLOAT_DIG);
        [$degrees, $minutes, $seconds, $direction] = $this->randomSexagesimal();
        $alfa = Angle::createFromValues($degrees, $minutes, $seconds, $direction);
        $beta = clone $alfa;
        $decimal = $beta->toFloat($precision);

        // Act & Assert
        $this->assertEquals($decimal, $alfa->toFloat($precision), $this->getCastError("decimal"));
    }

    #[TestDox("can be casted to radian.")]
    public function test_cast_to_radian()
    {
        /**
         * Built from radian value, no precision specified.
         */
        $radian = $this->randomFloat(
            max: Angle::MAX_RADIAN - PHP_FLOAT_MIN
        );
        $angle = Angle::createFromRadian($radian);

        // Act & Assert
        $this->assertEquals($radian, $angle->toRadian(), $this->getCastError("radian"));
    
        /**
         * Built from decimal degrees value,
         * no precision specified.
         */
        // Arrange
        $decimal = $this->faker->randomFloat(
            PHP_FLOAT_DIG,      /* Max available precision */
            -Angle::MAX_DEGREES, /* -360° */
            Angle::MAX_DEGREES   /* +360° */
        );
        $angle = Angle::createFromDecimal($decimal);

        // Act & Assert
        $this->assertEquals(deg2rad($decimal), $angle->toRadian(), $this->getCastError("radian"));

        /**
         * Built from decimal degrees value,
         * precision setted.
         */
        // Arrange
        $decimal = $this->faker->randomFloat(
            PHP_FLOAT_DIG,      /* Max available precision */
            -Angle::MAX_DEGREES, /* -360° */
            Angle::MAX_DEGREES   /* +360° */
        );
        $precision = 3;
        $angle = Angle::createFromDecimal($decimal);
        $expected_radian = round(
            deg2rad($decimal),
            $precision,
            RoundingMode::HalfTowardsZero
        );

        // Act & Assert
        $this->assertEquals($expected_radian, $angle->toRadian($precision), $this->getCastError("radian"));

        /**
         * All other cases, with precision.
         */
        // Arrange
        $precision = 3;
        $expected_radian = Number::PI($precision);
        $angle = Angle::createFromValues(180);
        
        // Act & Assert
        $this->assertEquals($expected_radian->value, $angle->toRadian($precision), $this->getCastError("radian"));

        /**
         * All other cases, without precision.
         */
        // Arrange
        $expected_radian = Number::PI(PHP_FLOAT_DIG);
        $angle = Angle::createFromValues(180);
        

        // Act & Assert
        $this->assertEquals($expected_radian->value, $angle->toRadian(), $this->getCastError("radian"));
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
    public function test_can_toggle_rotation_from_clockwise_to_counterclockwise()
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
        $this->assertEquals(Direction::COUNTER_CLOCKWISE, $beta_opposite->direction, $failure_message_1);
    }

    #[TestDox("can be tested if it is equal to another congruent string, integer, decimal or object angle.")]
    public function test_equal_comparison()
    {
        $this->markTestSkipped("Angle comparisons need a huge refactoring.");
        // Arrange
        $positive_alfa = $this->positiveRandomAngle();
        $positive_beta = clone $positive_alfa;
        $negative_gamma = $positive_beta->toggleDirection();
        $integer_positive_delta = Angle::createFromValues($this->randomDegrees());
        $integer_positive_epsilon = clone $integer_positive_delta;
        $integer_negative_zeta = $integer_positive_epsilon->toggleDirection();
        
        // Act & Assert
        $this->testAngleEqual($positive_alfa, $positive_beta);
        $this->testAngleEqual($positive_alfa, $positive_beta);
        $this->testAngleEqual($positive_alfa, $negative_gamma);
        $this->testIntegerAngleEqual($integer_positive_delta, $integer_positive_epsilon);
        $this->testIntegerAngleEqual($integer_positive_delta, $integer_negative_zeta);
    }

    #[TestDox("can sum two angles obtaining a relative result.")]
    public function test_can_sum_two_angles_and_return_relative_result()
    {
        $this->markTestSkipped("This test is waiting for refactoring.");
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
        $this->markTestSkipped("This test is waiting for refactoring.");
        // Arrange
        $alfa = $this->randomAngle();
        $beta = $this->randomAngle();

        // Act
        $gamma = Angle::absSum($alfa, $beta);

        // Assert
        $this->assertInstanceOf(Angle::class, $gamma, $this->methodMustReturn(
            Angle::class, "absSum", Angle::class
        ));
        $this->assertEquals(Angle::COUNTER_CLOCKWISE, $gamma->direction, 
            Angle::class."absSum() method must always return a positive angle."
        );
    }

    /**
     * It asserts an Angle can be casted to decimal.
     *
     * @param integer|null|null $precision
     * @return void
     */
    protected function testCasttoFloat(int|null $precision = null): void
    {
        // Arrange
        $decimal = $this->faker->randomFloat(
            $precision ?? $this->faker->numberBetween(0, PHP_FLOAT_DIG), 
            /* Min */ -Angle::MAX_DEGREES, /* Max */ Angle::MAX_DEGREES
        );
        $angle = Angle::createFromDecimal($decimal);
        
        // Act
        $result = $angle->toFloat($precision);

        // Assert
        $this->assertIsFloat($result);
        $this->assertEquals($decimal, $result, 
            "There was an error casting {$angle} to decimal with $precision precision digits. 
            Expected {$decimal}° but found {$result}°."
        );
    }

    /**
     * It asserts $first_angle is equal to $second_angle. 
     * This is a Parameterized Test.
    *
    * @param Angle $first_angle
    * @param Angle $second_angle
    * @param int|null $precision
    * @return void
    */
    protected function testAngleEqual(Angle $first_angle, Angle $second_angle, int|null $precision = null)
    {
        $failure_message_false = "$first_angle ≅ $second_angle is false.";
        $failure_message_true = "$first_angle ≇ $second_angle is true.";
        
        $this->assertTrue($first_angle->eq((string) $second_angle),                             $failure_message_false);
        $this->assertTrue($first_angle->eq($second_angle->toFloat($precision), $precision),   $failure_message_false);
        $this->assertTrue($first_angle->eq($second_angle),                                      $failure_message_false);
        $this->assertTrue($first_angle->equals($second_angle),                                  $failure_message_false);
        
        $this->assertFalse($first_angle->not((string) $second_angle),                           $failure_message_true);
        $this->assertFalse($first_angle->not($second_angle->toFloat($precision), $precision), $failure_message_true);
        $this->assertFalse($first_angle->not($second_angle),                                    $failure_message_true);
    }

    /**
     * It asserts $first_angle is equal to $second_angle. 
     * This is a Parameterized Test.
     *
     * @param Angle $first_angle
     * @param Angle $second_angle
     * @return void
     */
    protected function testIntegerAngleEqual(Angle $first_angle, Angle $second_angle)
    {
        $failure_message_false = "$first_angle ≅ $second_angle is false.";
        $failure_message_true = "$first_angle ≇ $second_angle is true.";
        
        $this->assertTrue(  $first_angle->eq($second_angle), $failure_message_false);
        $this->assertFalse($first_angle->not($second_angle), $failure_message_true);
    }
}