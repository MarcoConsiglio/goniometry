<?php declare(strict_types=1);
namespace MarcoConsiglio\Goniometry\Tests\Unit;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\AngleBuilder;
use MarcoConsiglio\Goniometry\Builders\FromAngles;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Builders\FromRadian;
use MarcoConsiglio\Goniometry\Builders\FromString;
use MarcoConsiglio\Goniometry\Builders\SumBuilder;
use MarcoConsiglio\Goniometry\Operations\Sum;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use RoundingMode;
use TypeError;

#[TestDox("An angle")]
#[CoversClass(Angle::class)]
#[UsesClass(AngleBuilder::class)]
#[UsesClass(FromString::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(FromDegrees::class)]
#[UsesClass(FromRadian::class)]
#[UsesClass(Sum::class)]
#[UsesClass(SumBuilder::class)]
#[UsesClass(FromAngles::class)]
class AngleTest extends TestCase
{
    /**
     * The expected degrees, minutes, seconds e angle direction.
     *
     * @var array
     */
    protected array $expected;

    /*
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->expected = $this->getRandomAngleDegrees();
    }

    #[TestDox("has read-only properties \"degrees\", \"minutes\", \"seconds\", \"direction\".")]
    public function test_getters()
    {
        // Arrange
        $failure_message = function (string $property) {
            return "$property property is not working correctly.";
        };
        /** @var \MarcoConsiglio\Goniometry\Angle&\PHPUnit\Framework\MockObject\MockObject $alfa */
        $alfa = $this->getMockedAngle();
        $this->setAngleProperties($alfa, [1, 2, 3.4]);

        // Act & Assert
        $this->assertEquals(1, $alfa->degrees, $failure_message("degrees"));
        $this->assertEquals(2, $alfa->minutes, $failure_message("minutes"));
        $this->assertEquals(3.4, $alfa->seconds, $failure_message("seconds"));
        $this->assertEquals(Angle::COUNTER_CLOCKWISE, $alfa->direction, $failure_message("direction"));
    }

    #[TestDox("can be created from separated values for degrees, minutes, seconds and direction.")]
    public function test_create_from_values()
    {
        // Arrange
        $degrees = $this->faker->numberBetween(0, 360);
        $minutes = $this->faker->numberBetween(0, 59);
        $seconds = $this->faker->numberBetween(0, 59);
        $direction = $this->faker->randomElement([Angle::COUNTER_CLOCKWISE, Angle::CLOCKWISE]);

        // Act
        $angle = Angle::createFromValues($degrees, $minutes, $seconds, $direction);

        // Assert
        $this->assertAngleHaveValues($angle, [
            "degrees" => $degrees * $direction,
            "minutes" => $minutes,
            "seconds" => $seconds,
        ]);
    }

    #[TestDox("can be created from a textual representation.")]
    public function test_create_from_string()
    {
        // Arrange
        $degrees = $this->faker->numberBetween(0, 360);
        $minutes = $this->faker->numberBetween(0, 59);
        $seconds = $this->faker->randomFloat(4, 0, 59.9999);
        $direction = $this->faker->randomElement(["-", ""]);
        $text = "{$direction}{$degrees}° {$minutes}' {$seconds}\"";

        // Act
        $angle = Angle::createFromString($text);

        // Act
        $this->assertAngleHaveValues($angle, [
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
            $angle->toDecimal()
        );
    }

    #[TestDox("can be created from a radian number.")]
    public function test_create_from_radiant()
    {
        // Arrange
        $radian = $this->faker->randomFloat(PHP_FLOAT_DIG, -Angle::MAX_RADIAN, Angle::MAX_RADIAN);

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
            $direction = $this->faker->randomElement([Angle::CLOCKWISE, Angle::COUNTER_CLOCKWISE])
        );
        $degrees *= $direction;

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
        $this->testCastToDecimal();
        $this->testCastToDecimal(0);
        $this->testCastToDecimal($this->faker->numberBetween(1, PHP_FLOAT_DIG - 3));
        $this->testCastToDecimal(PHP_FLOAT_DIG - 2);
        $this->testCastToDecimal(PHP_FLOAT_DIG);
        $this->testCastToDecimal(PHP_FLOAT_DIG + 3);
    }

    #[TestDox("can be casted to radian.")]
    public function test_cast_to_radiant()
    {
        /**
         * Built from radian value.
         */
        $radian = $this->faker->randomFloat(
            PHP_FLOAT_DIG,
            -Angle::MAX_RADIAN,
            Angle::MAX_RADIAN
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
        $expected_radian = round(2 * M_PI, $precision, RoundingMode::HalfTowardsZero);
        $angle = Angle::createFromValues(360);
        

        // Act & Assert
        $this->assertEquals($expected_radian, $angle->toRadian($precision), $this->getCastError("radian"));

        /**
         * All other cases, without precision.
         */
        // Arrange
        $expected_radian = 2 * M_PI;
        $angle = Angle::createFromValues(360);
        

        // Act & Assert
        $this->assertEquals($expected_radian, $angle->toRadian(), $this->getCastError("radian"));
    }

    #[TestDox("can be clockwise or negative.")]
    public function test_angle_is_clockwise()
    {
        // Arrange
        $alfa = $this->getRandomAngle(true);

        // Act & assert
        $this->assertTrue($alfa->isClockwise(), "The angle is clockwise but found the opposite.");
        $this->assertFalse($alfa->isCounterClockwise(), "The angle is not counter clockwise but found the opposite.");
    }

    #[TestDox("can be counterclockwise or positive.")]
    public function test_angle_is_counterclockwise()
    {
        // Arrange
        $alfa = $this->getRandomAngle(false);

        // Act & assert
        $this->assertTrue($alfa->isCounterClockwise(), "The angle is clockwise but found the opposite.");
        $this->assertFalse($alfa->isClockwise(), "The angle is not clockwise but found the opposite.");
    }

    #[TestDox("can toggle its direction.")]
    public function test_can_toggle_rotation_from_clockwise_to_counterclockwise()
    {
        // Arrange
        $alfa = $this->getRandomAngle(false);
        $beta = $this->getRandomAngle(true);

        // Act
        $alfa_opposite = $alfa->toggleDirection(); /* From positive to negative */
        $beta_opposite = $beta->toggleDirection(); /* From negative to positive */

        // Assert
        $failure_message_1 = "The angle should be counterclockwise but found the opposite.";
        $failure_message_2 = "The angle should be clockwise but found the opposite.";
        $this->assertEquals(Angle::CLOCKWISE, $alfa_opposite->direction, $failure_message_2);
        $this->assertEquals(Angle::COUNTER_CLOCKWISE, $beta_opposite->direction, $failure_message_1);
    }

    #[TestDox("can be tested if it is equal to another congruent string, integer, decimal or object angle.")]
    public function test_equal_comparison()
    {
        // Arrange
        $positive_alfa = $this->getRandomAngle();
        $positive_beta = clone $positive_alfa;
        $negative_gamma = $positive_beta->toggleDirection();
        $integer_positive_delta = Angle::createFromValues($this->faker->numberBetween(0, Angle::MAX_DEGREES));
        $integer_positive_epsilon = clone $integer_positive_delta;
        $integer_negative_zeta = $integer_positive_epsilon->toggleDirection();
        
        // Act & Assert
        $this->testAngleEqual($positive_alfa, $positive_beta);
        $this->testAngleEqual($positive_alfa, $positive_beta, $positive_alfa->suggested_decimal_precision);
        $this->testAngleEqual($positive_alfa, $negative_gamma);
        $this->testIntegerAngleEqual($integer_positive_delta, $integer_positive_epsilon);
        $this->testIntegerAngleEqual($integer_positive_delta, $integer_negative_zeta);
    }

    #[TestDox("throws an exception if equal comparison has an unexpected type argument.")]
    public function test_equal_comparison_exception()
    {
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
        // Arrange
        $precision = PHP_FLOAT_DIG;
        $positive_alfa = Angle::createFromDecimal($this->faker->randomFloat($precision, 180, 360));
        $positive_beta = Angle::createFromDecimal($this->faker->randomFloat($precision, 0, 179));
        $negative_delta = $positive_beta->toggleDirection();
        $positive_epsilon = Angle::createFromValues($this->faker->numberBetween(180, 360));
        $positive_zeta = Angle::createFromValues($this->faker->numberBetween(0, 179));
        $negative_eta = $positive_zeta->toggleDirection();

        // Act & Assert
        $this->testAngleGreaterThan($positive_alfa, $positive_beta);
        $this->testAngleGreaterThan($positive_alfa, $positive_beta, $precision);
        $this->testAngleGreaterThan($positive_alfa, $negative_delta);
        $this->testIntegerAngleGreatherThan($positive_epsilon, $positive_zeta);
        $this->testIntegerAngleGreatherThan($positive_epsilon, $negative_eta);
    }

    #[TestDox("throws an exception if greater than comparison has an unexpected type argument.")]
    public function test_greater_than_comparison_exception()
    {
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
        // Arrange
        $precision = PHP_FLOAT_DIG;
        $positive_alfa = Angle::createFromDecimal($this->faker->randomFloat($precision, 180, 360));
        $positive_beta = Angle::createFromDecimal($this->faker->randomFloat($precision, 0, 179.9));
        $negative_gamma = $positive_beta->toggleDirection();
        $positive_delta = Angle::createFromValues($this->faker->numberBetween(180, 360));
        $positive_epsilon = Angle::createFromValues($this->faker->numberBetween(0, 179));
        $negative_zeta = $positive_epsilon->toggleDirection();
        
        // Act & Assert
        $this->testAngleGreaterThanOrEqual($positive_alfa, $positive_beta);
        $this->testAngleGreaterThanOrEqual($positive_alfa, $positive_beta, $precision);
        $this->testAngleGreaterThanOrEqual($positive_alfa, $negative_gamma);
        $this->testIntegerAngleGreatherThanOrEqual($positive_delta, $positive_epsilon);
        $this->testIntegerAngleGreatherThanOrEqual($positive_delta, $negative_zeta);
    }

    #[TestDox("throws an exception if greater than or equal comparison has an unexpected type argument.")]
    public function test_greater_than_or_equal_comparison_exception()
    {
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
        // Arrange
        $precision = PHP_FLOAT_DIG;
        $positive_alfa = Angle::createFromDecimal($this->faker->randomFloat($precision, 0, 179.9));
        $positive_beta = Angle::createFromDecimal($this->faker->randomFloat($precision, 180, 360));
        $negative_gamma = $positive_beta->toggleDirection();
        $positive_delta = Angle::createFromValues($this->faker->numberBetween(0, 179));
        $positive_epsilon = Angle::createFromValues($this->faker->numberBetween(180, 360));
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
        // Arrange
        $precision = PHP_FLOAT_DIG;
        $positive_alfa = Angle::createFromDecimal($this->faker->randomFloat($precision, 0, 179.9));
        $positive_beta = Angle::createFromDecimal($this->faker->randomFloat($precision, 180, 360));
        $negative_gamma = $positive_beta->toggleDirection();
        $positive_delta = Angle::createFromValues($this->faker->numberBetween(0, 179));
        $positive_epsilon = Angle::createFromValues($this->faker->numberBetween(180, 360));
        $negative_zeta = $positive_epsilon->toggleDirection();

        // Act & Assert
        $this->testAngleLessThanOrEqual($positive_alfa, $positive_beta);
        $this->testAngleLessThanOrEqual($positive_alfa, clone $positive_alfa);
        $this->testAngleLessThanOrEqual($positive_alfa, $positive_beta, $precision);
        $this->testAngleLessThanOrEqual($positive_alfa, $negative_gamma);
        $this->testIntegerAngleLessThanOrEqual($positive_delta, $positive_epsilon);
        $this->testIntegerAngleLessThanOrEqual($positive_delta, $negative_zeta);
    }

    #[TestDox("throws an exception if less than or equal comparison has an unexpected type.")]
    public function test_less_then_or_equal_comparison_exception()
    {
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
        // Arrange
        $precision = PHP_FLOAT_DIG;
        $positive_alfa = Angle::createFromDecimal($this->faker->randomFloat($precision, 180, 360));
        $positive_beta = Angle::createFromDecimal($this->faker->randomFloat($precision, 0, 179.9));
        $negative_gamma = $positive_beta->toggleDirection();
        $positive_delta = Angle::createFromValues($this->faker->numberBetween(180, 360));
        $positive_epsilon = Angle::createFromValues($this->faker->numberBetween(0, 179));
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
        // Arrange
        /** @var \MarcoConsiglio\Goniometry\Angle&\PHPUnit\Framework\MockObject\MockObject $alfa */
        $alfa = $this->getMockedAngle(["toDecimal"]);
        $alfa->expects($this->never())->method("toDecimal");
        $invalid_argument = true;
        
        // Act & Assert
        $this->expectException(TypeError::class);
        $alfa->not($invalid_argument); // Two birds with one stone.
    }

    #[TestDox("can sums two angles.")]
    public function test_sum_two_angles()
    {
        // Arrange
        $alfa = $this->getRandomAngle($this->faker->boolean());
        $beta = $this->getRandomAngle($this->faker->boolean());
        $decimal_alfa = $alfa->toDecimal();
        $decimal_beta = $beta->toDecimal();
        $precision = max(
            Angle::countDecimalPlaces($decimal_alfa), 
            Angle::countDecimalPlaces($decimal_beta)
        );
        $decimal_sum = $decimal_alfa + $decimal_beta;
        $sign = $decimal_sum >= 0 ? Angle::COUNTER_CLOCKWISE : Angle::CLOCKWISE;
        if (abs($decimal_sum) > Angle::MAX_DEGREES) $decimal_sum = (abs($decimal_sum) - Angle::MAX_DEGREES) * $sign;
        $decimal_sum = round($decimal_sum, $precision, RoundingMode::HalfTowardsZero);
        
        // Act
        $gamma = Angle::sum($alfa, $beta);

        // Assert
        $failure_message = function(Angle $alfa, Angle $beta, Angle $gamma) {
            return <<<TEXT
+ $alfa
= $beta
------------------
  $gamma
TEXT;
        };
        $this->assertEquals($decimal_sum, $gamma->toDecimal(), $failure_message($alfa, $beta, $gamma));
    }

    
    /**
     * Assert the passed $values are the same of $angle. 
     * This is a Custom Assertion.
    *
    * @param Angle $angle The angle being tested.
    * @param array $values The expected values of the angle.
    * @return void
    */
    protected function assertAngleHaveValues(Angle $angle, array $values)
    {
        $expected_values = $angle->getDegrees(true);
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
        
        $this->assertTrue($first_angle->gte($second_angle->degrees),  $failure_message_false);
        $this->assertFalse($second_angle->lt($second_angle->degrees), $failure_message_true);
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
        
        $this->assertTrue(  $first_angle->eq($second_angle->degrees), $failure_message_false);
        $this->assertFalse($first_angle->not($second_angle->degrees), $failure_message_true);
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
        $this->assertTrue($first_angle->not($second_angle->degrees), $failure_message_false);
        $this->assertFalse($first_angle->eq($second_angle->degrees), $failure_message_true);
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
        
        $this->assertTrue($first_angle->lt($second_angle->degrees), $failure_message_false);
        $this->assertFalse($first_angle->gte($second_angle->degrees), $failure_message_true);
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
        $failure_message_false = "$first_angle ≦ $second_angle is false.";
        $failure_message_true = "$first_angle > $second_angle is true.";
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
        
        $this->assertTrue( $first_angle->lte($second_angle->degrees), $failure_message_false);
        $this->assertFalse($first_angle->gt($second_angle->degrees), $failure_message_true);
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
     * Gets a casting error message.
     *
     * @param string $type Type to cast to.
     * @return string
     */
    protected function getCastError(string $type): string
    {
        return "Something is not working when casting to $type.";
    }
}