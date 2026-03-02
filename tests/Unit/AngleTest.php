<?php declare(strict_types=1);
namespace MarcoConsiglio\Goniometry\Tests\Unit;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\AngleBuilder;
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
use MarcoConsiglio\Goniometry\Tests\Traits\WithEqualsMethod;
use MarcoConsiglio\Goniometry\Tests\Unit\Builders\FromDecimalTest;
use MarcoConsiglio\Goniometry\Tests\Unit\Builders\FromDegreesTest;
use MarcoConsiglio\Goniometry\Tests\Unit\Builders\FromRadianTest;
use MarcoConsiglio\Goniometry\Tests\Unit\Builders\FromStringTest;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\DependsOnClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use RoundingMode;
use TypeError;

#[TestDox("An Angle")]
#[CoversClass(Angle::class)]
#[UsesClass(AngleBuilder::class)]
#[UsesClass(FromString::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(FromDegrees::class)]
#[UsesClass(FromRadian::class)]
#[UsesClass(SumBuilder::class)]
#[UsesClass(FromAnglesToRelativeSum::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class AngleTest extends TestCase
{
    use WithEqualsMethod;

    /*
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

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

    #[TestDox("which is null has always counter-clockwise direction.")]
    public function test_null_angle_direction(): void
    {
        // Arrange
        $alfa = Angle::createFromValues(0, 0, 0, Direction::CLOCKWISE);

        // Assert
        $this->assertEquals(Direction::COUNTER_CLOCKWISE, $alfa->direction);
    }

    #[TestDox("has read-only property \"original_seconds_precision\" which is an integer.")]
    public function test_original_seconds_precision()
    {
        $this->markTestSkipped("This test will no longer be needed once we 
        have completed the refactoring to replace the Angle class's degrees, 
        minutes, and seconds type with the ModularNumber type.");
        // Arrange
        $seconds = $this->faker->randomFloat(PHP_FLOAT_DIG, 0, Angle::MAX_SECONDS - 0.00000001);
        $seconds_precision = Angle::countDecimalPlaces($seconds);
        $alfa = Angle::createFromValues(0, 0, $seconds);

        // Act & Assert
        $this->assertEquals($seconds_precision, $alfa->original_seconds_precision, 
            $this->getPropertyError("original_seconds_precision")
        );
    }

    #[TestDox("has read-only property \"suggested_decimal_precision\" which is an integer.")]
    public function test_suggested_decimal_precision()
    {
        $this->markTestSkipped("This test will no longer be needed once we 
        have completed the refactoring to replace the Angle class's degrees, 
        minutes, and seconds type with the ModularNumber type.");
        // Arrange
        $alfa = $this->getRandomAngle($this->faker->boolean());
        $decimal_precision = $alfa->original_seconds_precision + 6;
        if ($decimal_precision > PHP_FLOAT_DIG) $decimal_precision = PHP_FLOAT_DIG;

        // Act & Assert
        $this->assertEquals($decimal_precision, $alfa->suggested_decimal_precision,
            $this->getPropertyError("suggested_decimal_precision")
        );
    }

    #[TestDox("has read-only property \"original_radian_precision\" which is an integer.")]
    public function test_original_radian_precision()
    {
        $this->markTestSkipped("This test will no longer be needed once we 
        have completed the refactoring to replace the Angle class's degrees, 
        minutes, and seconds type with the ModularNumber type.");
        /**
         * Angle built with sexagesimal degrees.
         */
        // Arrange
        $alfa = $this->getRandomAngle($this->faker->boolean());

        // Act & Assert
        $this->assertNull($alfa->original_radian_precision, $this->getPropertyError("original_radian_precision"));

        /**
         * Angle built with radian.
         */
        // Arrange
        $radian = $this->faker->randomFloat(PHP_FLOAT_DIG, -Angle::MAX_RADIAN, Angle::MAX_RADIAN);
        $radian_precision = Angle::countDecimalPlaces($radian);
        $beta = Angle::createFromRadian($radian);

        // Act & Assert
        $this->assertEquals($radian_precision, $beta->original_radian_precision,
            $this->getPropertyError("original_radian_precision")
        );
    }

    // #[DependsOnClass(FromDegreesTest::class)]
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

    #[DependsOnClass(FromStringTest::class)]
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

    #[DependsOnClass(FromDecimalTest::class)]
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
            $angle->toDecimal()
        );
    }

    #[DependsOnClass(FromRadianTest::class)]
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

    #[Depends("test_angle_is_clockwise")]
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
        $this->testCastToDecimal();
        $this->testCastToDecimal(0);
        $this->testCastToDecimal($this->faker->numberBetween(1, PHP_FLOAT_DIG - 3));
        $this->testCastToDecimal(PHP_FLOAT_DIG - 2);
        $this->testCastToDecimal(PHP_FLOAT_DIG);
        $this->testCastToDecimal(PHP_FLOAT_DIG + 3);

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
        $decimal = $beta->toDecimal($precision);

        // Act & Assert
        $this->assertEquals($decimal, $alfa->toDecimal($precision), $this->getCastError("decimal"));
    }

    #[DependsOnClass(FromRadianTest::class)]
    #[TestDox("can be casted to radian.")]
    public function test_cast_to_radiant()
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

    #[Depends("test_cast_to_decimal")]
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

    #[TestDox("support PHPUnit assertObjectEquals() method.")]
    public function test_equals_method()
    {
        $this->testEqualComparison(3);
    }

    #[TestDox("throws an exception if equal comparison has an unexpected type argument.")]
    public function test_equal_comparison_exception()
    {
        $this->markTestSkipped("Angle comparisons need a huge refactoring.");
        // Arrange
        /** @var \MarcoConsiglio\Goniometry\Angle&\PHPUnit\Framework\MockObject\MockObject $alfa  */
        $alfa = $this->getMockedAngle(["toDecimal"]);
        $alfa->expects($this->never())->method("toDecimal");
        $invalid_argument = true;

        // Act & Assert
        $this->expectException(TypeError::class);
        $alfa->eq($invalid_argument); /* Two birds with one stone. */
    }

    #[TestDox("can be tested if it is greater than another string, integer, decimal or object angle.")]
    public function test_greater_than_comparison()
    {
        $this->markTestSkipped("Angle comparisons need a huge refactoring.");
        // Arrange
        $this->randomDegrees();
        $positive_alfa = Angle::createFromDecimal($this->positiveRandomSexadecimal(min: 180));
        $positive_beta = Angle::createFromDecimal($this->positiveRandomSexadecimal(max: 180 - PHP_FLOAT_MIN));
        $negative_delta = $positive_beta->toggleDirection();

        // Act & Assert
        $this->testAngleGreaterThan($positive_alfa, $positive_beta);
        $this->testAngleGreaterThan($positive_alfa, $positive_beta);
        $this->testAngleGreaterThan($positive_alfa, $negative_delta);
    }

    #[TestDox("throws an exception if greater than comparison has an unexpected type argument.")]
    public function test_greater_than_comparison_exception()
    {
        $this->markTestSkipped("Angle comparisons need a huge refactoring.");
        // Arrange
        /** @var \MarcoConsiglio\Goniometry\Angle&\PHPUnit\Framework\MockObject\MockObject $alfa  */
        $alfa = $this->getMockedAngle(["toDecimal"]);
        $alfa->expects($this->never())->method("toDecimal");
        $invalid_argument = true;
        
        // Act & Assert
        $this->expectException(TypeError::class);
        $alfa->gt($invalid_argument); // Two birds with one stone.
    }

    #[TestDox("can be tested if it is greater than or equal another string, integer, decimal or object angle.")]
    public function test_greater_than_or_equal_comparison()
    {
        $this->markTestSkipped("Angle comparisons need a huge refactoring.");
        // Arrange
        $positive_alfa = Angle::createFromDecimal($this->positiveRandomSexadecimal(min: 180));
        $positive_beta = Angle::createFromDecimal($this->positiveRandomSexadecimal(max: 180 - PHP_FLOAT_MIN));
        $negative_gamma = $positive_beta->toggleDirection();
        $positive_delta = Angle::createFromDecimal($this->positiveRandomSexadecimal(min: 180));
        $positive_epsilon = Angle::createFromDecimal($this->positiveRandomSexadecimal(max: 180 - PHP_FLOAT_MIN));
        $negative_zeta = $positive_epsilon->toggleDirection();
        
        // Act & Assert
        $this->testAngleGreaterThanOrEqual($positive_alfa, $positive_beta);
        $this->testAngleGreaterThanOrEqual($positive_alfa, $positive_beta);
        $this->testAngleGreaterThanOrEqual($positive_alfa, $negative_gamma);
        $this->testIntegerAngleGreatherThanOrEqual($positive_delta, $positive_epsilon);
        $this->testIntegerAngleGreatherThanOrEqual($positive_delta, $negative_zeta);
    }

    #[TestDox("throws an exception if greater than or equal comparison has an unexpected type argument.")]
    public function test_greater_than_or_equal_comparison_exception()
    {
        $this->markTestSkipped("Angle comparisons need a huge refactoring.");
        // Arrange
        /** @var \MarcoConsiglio\Goniometry\Angle&\PHPUnit\Framework\MockObject\MockObject $alfa  */
        $alfa = $this->getMockedAngle(["toDecimal"]);
        $alfa->expects($this->never())->method("toDecimal");
        $invalid_argument = true;
        
        // Act & Assert
        $this->expectException(TypeError::class);
        $alfa->gte($invalid_argument); // Two birds with one stone.
    }

    #[TestDox("can be tested if it is less than another string, integer, decimal or object angle.")]
    public function test_less_than_comparison()
    {
        $this->markTestSkipped("Angle comparisons need a huge refactoring.");
        // Arrange
        $precision = PHP_FLOAT_DIG;
        $positive_alfa = Angle::createFromDecimal($this->positiveRandomSexadecimal(max: 180 - PHP_FLOAT_MIN));
        $positive_beta = Angle::createFromDecimal($this->positiveRandomSexadecimal(min: 180));
        $negative_gamma = $positive_beta->toggleDirection();
        $positive_delta = Angle::createFromDecimal($this->positiveRandomSexadecimal(max: 180 - PHP_FLOAT_MIN));
        $positive_epsilon = Angle::createFromDecimal($this->positiveRandomSexadecimal(min: 180));
        $negative_zeta = $positive_epsilon->toggleDirection();

        // Act & Assert
        $this->testAngleLessThan($positive_alfa, $positive_beta);
        $this->testAngleLessThan($positive_alfa, $positive_beta, $precision);
        $this->testAngleLessThan($positive_alfa, $negative_gamma);
        $this->testIntegerAngleLessThan($positive_delta, $positive_epsilon);
        $this->testIntegerAngleLessThan($positive_delta, $negative_zeta);
    }

    #[TestDox("throws an exception if less than comparison has an unexpected type argument.")]
    public function test_less_than_comparison_exception()
    {
        $this->markTestSkipped("Angle comparisons need a huge refactoring.");
        // Arrange
        /** @var \MarcoConsiglio\Goniometry\Angle&\PHPUnit\Framework\MockObject\MockObject $alfa */
        $alfa = $this->getMockedAngle(["toDecimal"]);
        $alfa->expects($this->never())->method("toDecimal");
        $invalid_argument = true;

        // Act & Assert
        $this->expectException(TypeError::class);
        $alfa->lt($invalid_argument); // Two birds with one stone.
    }

    #[TestDox("can be tested if it is less than or equal another string, integer, decimal or object angle.")]
    public function test_less_than_or_equal_comparison()
    {
        $this->markTestSkipped("Angle comparisons need a huge refactoring.");
        // Arrange
        $positive_alfa = Angle::createFromDecimal($this->positiveRandomSexadecimal(max: 180 - PHP_FLOAT_MIN));
        $positive_beta = Angle::createFromDecimal($this->positiveRandomSexadecimal(min: 180));
        $negative_gamma = $positive_beta->toggleDirection();
        $positive_delta = Angle::createFromDecimal($this->positiveRandomSexadecimal(max: 180 - PHP_FLOAT_MIN));
        $positive_epsilon = Angle::createFromDecimal($this->positiveRandomSexadecimal(min: 180));
        $negative_zeta = $positive_epsilon->toggleDirection();

        // Act & Assert
        $this->testAngleLessThanOrEqual($positive_alfa, $positive_beta);
        $this->testAngleLessThanOrEqual($positive_alfa, clone $positive_alfa);
        $this->testAngleLessThanOrEqual($positive_alfa, $positive_beta);
        $this->testAngleLessThanOrEqual($positive_alfa, $negative_gamma);
        $this->testIntegerAngleLessThanOrEqual($positive_delta, $positive_epsilon);
        $this->testIntegerAngleLessThanOrEqual($positive_delta, $negative_zeta);
    }

    #[TestDox("throws an exception if less than or equal comparison has an unexpected type.")]
    public function test_less_then_or_equal_comparison_exception()
    {
        $this->markTestSkipped("Angle comparisons need a huge refactoring.");
        // Arrange
        /** @var \MarcoConsiglio\Goniometry\Angle&\PHPUnit\Framework\MockObject\MockObject $alfa */
        $alfa = $this->getMockedAngle(["toDecimal"]);
        $alfa->expects($this->never())->method("toDecimal");
        $invalid_argument = true;
        
        // Act & Assert
        $this->expectException(TypeError::class);
        $alfa->lte($invalid_argument); // Two birds with one stone.
    }

    #[TestDox("can be tested if it is different than another string, integer, decimal or object angle.")]
    public function test_is_different_comparison()
    {
        $this->markTestSkipped("Angle comparisons need a huge refactoring.");
        // Arrange
        $precision = PHP_FLOAT_DIG;
        $positive_alfa = Angle::createFromDecimal($this->faker->randomFloat($precision, 180, 360));
        $positive_beta = Angle::createFromDecimal($this->faker->randomFloat($precision, 0, 179.9));
        $negative_gamma = $positive_beta->toggleDirection();
        $positive_delta = Angle::createFromDecimal($this->faker->numberBetween(180, 360));
        $positive_epsilon = Angle::createFromDecimal($this->faker->numberBetween(0, 179));
        $negative_zeta = $positive_epsilon->toggleDirection();

        // Act & Assert
        $this->testAngleDifferent($positive_alfa, $positive_beta);
        $this->testAngleDifferent($positive_alfa, $positive_beta, $precision);
        $this->testAngleDifferent($positive_alfa, $negative_gamma);
        $this->testIntegerAngleDifferent($positive_delta, $positive_epsilon);
        $this->testIntegerAngleDifferent($positive_delta, $negative_zeta);
    }

    #[TestDox("throws an exception if different comparison has an unexpected type.")]
    public function test_is_different_comparison_exception()
    {
        $this->markTestSkipped("Angle comparisons need a huge refactoring.");
        // Arrange
        /** @var \MarcoConsiglio\Goniometry\Angle&\PHPUnit\Framework\MockObject\MockObject $alfa */
        $alfa = $this->getMockedAngle(["toDecimal"]);
        $alfa->expects($this->never())->method("toDecimal");
        $invalid_argument = true;
        
        // Act & Assert
        $this->expectException(TypeError::class);
        $alfa->not($invalid_argument); // Two birds with one stone.
    }
    
    /**
     * Assert the passed $values are the same of $angle. 
     * This is a Custom Assertion.
    *
    * @param Angle $angle The angle being tested.
    * @param array $expected_values The expected values of the angle.
    * @return void
    */
    protected function assertAngleHasValues(Angle $angle, array $expected_values)
    {
        $values = $angle->getDegrees(true);
        $this->assertEquals($expected_values["degrees"], $values["degrees"]);
        $this->assertEquals($expected_values["minutes"], $values["minutes"]);
        $this->assertEquals($expected_values["seconds"], $values["seconds"]);
    }
    
    /**
     * It asserts $first_angle is greater than $second_angle. 
     * This is a Parameterized Test.
    *
    * @param Angle $first_angle
    * @param Angle $second_angle
    * @param int|null $precision
    * @return void
    */
    protected function testAngleGreaterThan(Angle $first_angle, Angle $second_angle, int|null $precision = null)
    {
        $failure_message = "$first_angle > $second_angle is false.";
        $failure_message = "$first_angle ≦ $second_angle is false.";
        
        $this->assertTrue($first_angle->gt((string) $second_angle),                            $failure_message);
        $this->assertTrue($first_angle->gt($second_angle->toDecimal($precision), $precision),  $failure_message);
        $this->assertTrue($first_angle->gt($second_angle),                                     $failure_message);
        
        $this->assertFalse($first_angle->lte((string) $second_angle),                           $failure_message);
        $this->assertFalse($first_angle->lte($second_angle->toDecimal($precision), $precision), $failure_message);
        $this->assertFalse($first_angle->lte($second_angle),                                    $failure_message);
    }
    
    /**
     * It asserts $first_angle is greater than $second_angle. 
     * This is a Parameterized Test.
    *
    * @param Angle $first_angle
     * @param Angle $second_angle
     * @return void
    */
    protected function testIntegerAngleGreatherThan(Angle $first_angle, Angle $second_angle)
    {
        $failure_message_false = "$first_angle > $second_angle is false.";
        $failure_message_true = "$first_angle ≦ $second_angle is true.";
        
        $this->assertTrue($first_angle->gt($second_angle->degrees),  $failure_message_false);
        $this->assertFalse($first_angle->lte($second_angle->degrees), $failure_message_true);
    }
    
    /**
     * It asserts $first_angle is greater than or equal to $second_angle. 
     * This is a Parameterized Test.
    *
    * @param Angle $first_angle
    * @param Angle $second_angle
     * @param int|null $precision
     * @return void
    */
    protected function testAngleGreaterThanOrEqual(Angle $first_angle, Angle $second_angle, int|null $precision = null)
    {
        $failure_message_false = "$first_angle ≧ $second_angle is false.";
        $failure_message_true = "$first_angle < $second_angle is true.";
        
        $this->assertTrue($first_angle->gte((string) $second_angle),               $failure_message_false);
        $this->assertTrue($first_angle->gte($second_angle->toDecimal($precision)), $failure_message_false);
        $this->assertTrue($first_angle->gte($second_angle),                        $failure_message_false);
        
        $this->assertFalse($first_angle->lt((string) $second_angle),               $failure_message_true);
        $this->assertFalse($first_angle->lt($second_angle->toDecimal($precision)), $failure_message_true);
        $this->assertFalse($first_angle->lt($second_angle),                        $failure_message_true);
    }
    
    /**
     * It asserts $first_angle is greater than or equal to $second_angle. 
     * This is a Parameterized Test.
    *
    * @param Angle $first_angle
    * @param Angle $second_angle
    * @return void
    */
    protected function testIntegerAngleGreatherThanOrEqual(Angle $first_angle, Angle $second_angle)
    {
        $failure_message_false = "$first_angle ≧ $second_angle is false.";
        $failure_message_true = "$first_angle < $second_angle is true.";
        
        $this->assertTrue($first_angle->gte($second_angle),  $failure_message_false);
        $this->assertFalse($second_angle->lt($second_angle), $failure_message_true);
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
        $this->assertTrue($first_angle->eq($second_angle->toDecimal($precision), $precision),   $failure_message_false);
        $this->assertTrue($first_angle->eq($second_angle),                                      $failure_message_false);
        $this->assertTrue($first_angle->equals($second_angle),                                  $failure_message_false);
        
        $this->assertFalse($first_angle->not((string) $second_angle),                           $failure_message_true);
        $this->assertFalse($first_angle->not($second_angle->toDecimal($precision), $precision), $failure_message_true);
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

    /**
     * It asserts $first_angle is different than $second_angle.
     * This is a Parameterized Test.
    *
    * @param Angle $first_angle
    * @param Angle $second_angle
    * @param int|null $precision
    * @return void
     */
    protected function testAngleDifferent(Angle $first_angle, Angle $second_angle, int|null $precision = null) 
    {
        $failure_message_false = "$first_angle ≇ $second_angle is false.";
        $failure_message_true = "$first_angle ≅ $second_angle is true.";
        
        $this->assertTrue($first_angle->not((string) $second_angle),               $failure_message_false);
        $this->assertTrue($first_angle->not($second_angle->toDecimal($precision)), $failure_message_false);
        $this->assertTrue($first_angle->not($second_angle),                        $failure_message_false);
        
        $this->assertFalse($first_angle->eq((string) $second_angle),               $failure_message_true);
        $this->assertFalse($first_angle->eq($second_angle->toDecimal($precision)), $failure_message_true);
        $this->assertFalse($first_angle->eq($second_angle),                        $failure_message_true);
        $this->assertFalse($first_angle->equals($second_angle),                    $failure_message_true);
    }
    
    /**
     * It asserts $first_angle is different than $second_angle.
     * This is a Parameterized Test.
    *
    * @param Angle $first_angle
     * @param Angle $second_angle
     * @return void
    */
    protected function testIntegerAngleDifferent(Angle $first_angle, Angle $second_angle)
    {
        $failure_message_false = "$first_angle ≇ $second_angle is false.";
        $failure_message_true = "$first_angle ≅ $second_angle is true.";
        $this->assertTrue($first_angle->not($second_angle), $failure_message_false);
        $this->assertFalse($first_angle->eq($second_angle), $failure_message_true);
    }
    
    /**
     * It asserts that $first_angle is less than $second_angle.
     * This is a Parameterized Test.
    *
    * @param Angle $first_angle
    * @param Angle $second_angle
    * @param int|null $precision
    * @return void
    */
    protected function testAngleLessThan(Angle $first_angle, Angle $second_angle, int|null $precision = null)
    {
        $failure_message_false = "$first_angle < $second_angle is false.";
        $failure_message_true = "$first_angle ≧ $second_angle is true.";
        $this->assertTrue($first_angle->lt((string) $second_angle),                 $failure_message_false);
        $this->assertTrue($first_angle->lt($second_angle->toDecimal($precision)),   $failure_message_false);
        $this->assertTrue($first_angle->lt($second_angle),                          $failure_message_false);
        
        $this->assertFalse($first_angle->gte((string) $second_angle),               $failure_message_true);
        $this->assertFalse($first_angle->gte($second_angle->toDecimal($precision)), $failure_message_true);
        $this->assertFalse($first_angle->gte($second_angle),                        $failure_message_true);
    }
    
    /**
     * It asserts that $first_angle is less than $second_angle.
     * This is a Parameterized Test.
    *
    * @param Angle $first_angle
    * @param Angle $second_angle
    * @return void
     */
    protected function testIntegerAngleLessThan(Angle $first_angle, Angle $second_angle)
    {
        $failure_message_false = "$first_angle < $second_angle is false.";
        $failure_message_true = "$first_angle ≧ $second_angle is true.";
        
        $this->assertTrue($first_angle->lt($second_angle), $failure_message_false);
        $this->assertFalse($first_angle->gte($second_angle), $failure_message_true);
    }
    
    /**
     * It asserts $first_angle is less than or equal to $second_angle. 
     * This is a Parameterized Test.
    *
    * @param Angle $first_angle
    * @param Angle $second_angle
    * @param int|null $precision
    * @return void
     */
    protected function testAngleLessThanOrEqual(Angle $first_angle, Angle $second_angle, int|null $precision = null)
    {
        $failure_message_false = "$first_angle ≦ $second_angle is false intead of expected true.";
        $failure_message_true = "$first_angle > $second_angle is true instead of expected false.";
        $this->assertTrue($first_angle->lte((string) $second_angle),               $failure_message_false);
        $this->assertTrue($first_angle->lte($second_angle->toDecimal($precision)), $failure_message_false);
        $this->assertTrue($first_angle->lte($second_angle),                        $failure_message_false);
        $this->assertFalse($first_angle->gt((string) $second_angle),               $failure_message_true);
        $this->assertFalse($first_angle->gt($second_angle->toDecimal($precision)), $failure_message_true);
        $this->assertFalse($first_angle->gt($second_angle),                        $failure_message_true);
    }
    
    /**
     * It asserts $first_angle is less than or equal to $second_angle. 
     * This is a Parameterized Test.
    *
    * @param Angle $first_angle
    * @param Angle $second_angle
     * @return void
     */
    protected function testIntegerAngleLessThanOrEqual(Angle $first_angle, Angle $second_angle)
    {
        $failure_message_false = "$first_angle ≦ $second_angle is false.";
        $failure_message_true = "$first_angle > $second_angle is true.";      
        
        $this->assertTrue( $first_angle->lte($second_angle), $failure_message_false);
        $this->assertFalse($first_angle->gt($second_angle), $failure_message_true);
    }

    /**
     * It asserts an Angle can be casted to decimal.
    *
    * @param integer|null|null $precision
    * @return void
    */
    protected function testCastToDecimal(int|null $precision = null): void
    {
        // Arrange
        $decimal = $this->faker->randomFloat(
            $precision ?? $this->faker->numberBetween(0, PHP_FLOAT_DIG), 
            /* Min */ -Angle::MAX_DEGREES, /* Max */ Angle::MAX_DEGREES
        );
        $angle = Angle::createFromDecimal($decimal);
        
        // Act
        $result = $angle->toDecimal($precision);

        // Assert
        $this->assertIsFloat($result);
        $this->assertEquals($decimal, $result, 
            "There was an error casting {$angle} to decimal with $precision precision digits. 
            Expected {$decimal}° but found {$result}°."
        );
    }

    /**
     * It produces a casting error message.
     *
     * @param string $type Type to cast to.
     * @return string
     */
    protected function getCastError(string $type): string
    {
        return "Something is not working when casting to $type.";
    }

    /**
     * It produces a property error message.
     *
     * @param string $property_name
     * @return string
     */
    protected function getPropertyError(string $property_name): string
    {
        return "Angle::\${$property_name} property is not working correctly.";
    }

    /**
     * Return a comparison dataset with different and equal arguments.
     * 
     * @return array
     */
    protected function getComparisonDataset(): array
    {
        $d1 = 180;
        $d2 = 90;
        $m1 = 20;
        $m2 = 30;
        $s1 = 10;
        $s2 = 50;
        return [
            0 => [
                self::DIFFERENT => [$d1, $d2],
                self::EQUAL => [$d1, $d1]
            ],
            1 => [
                self::DIFFERENT => [$m1, $m2],
                self::EQUAL => [$m1, $m1]
            ],
            2 => [
                self::DIFFERENT => [$s1, $s2],
                self::EQUAL => [$s1, $s1]
            ]
        ];
    }

    /**
     * Construct the two records to be compared with some $property_couples 
     * representing an equal or different property
     * 
     * @param array $property_couples
     * @return array
     */
    protected function getRecordsToCompare(array $property_couples): array
    {
        $first = 0;
        $second = 1;
        return [
            Angle::createFromValues(
                $property_couples[0][$first],
                $property_couples[1][$first],
                $property_couples[2][$first],
            ),
            Angle::createFromValues(
                $property_couples[0][$second],
                $property_couples[1][$second],
                $property_couples[2][$second],
            )
        ];
    }
}