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
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;
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
        $this->assertNull($alfa->asganway);
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
        $seconds = $this->faker->numberBetween(0, 59.9);
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
            round($decimal, 1, RoundingMode::HalfTowardsZero), 
            $angle->toDecimal(1)
        );
    }

    #[TestDox("can be created from a radian number.")]
    public function test_create_from_radiant()
    {
        // Arrange
        $precision = 5;
        $radian = $this->faker->randomFloat($precision, -Angle::MAX_RADIAN, Angle::MAX_RADIAN);

        // Act
        $angle = Angle::createFromRadian($radian);

        // Assert
        $this->assertEquals($radian, $angle->toRadian($precision));
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
        /** @var \MarcoConsiglio\Goniometry\Angle&\PHPUnit\Framework\MockObject\MockObject $alfa */
        $alfa = $this->getMockedAngle(["isClockwise"]);
        /** @var \MarcoConsiglio\Goniometry\Angle&\PHPUnit\Framework\MockObject\MockObject $beta */
        $beta = $this->getMockedAngle(["isClockWise"]);
        $alfa->expects($this->once())->method("isClockwise")->willReturn(false);
        $this->setAngleProperties($alfa, [1, 2, 3.4]);
        $expected_alfa_string = "1° 2' 3.4\"";
        $beta->expects($this->once())->method("isClockwise")->willReturn(true);
        $this->setAngleProperties($beta, [1, 2, 3.4, Angle::CLOCKWISE]);
        $expected_beta_string = "-" . $expected_alfa_string;

        // Act & Assert
        $this->assertEquals($expected_alfa_string, (string) $alfa, $this->getCastError("string"));
        $this->assertEquals($expected_beta_string, (string) $beta, $this->getCastError("string"));
    }

    #[TestDox("can be casted to decimal.")]
    public function test_cast_to_decimal()
    {
        // Arrange
        $precision = PHP_FLOAT_DIG;
        $decimal = $this->faker->randomFloat(
            $precision,             /* Max available precision */
            -Angle::MAX_DEGREES,    /* -360° */
            Angle::MAX_DEGREES      /* +360° */
        );
        $angle = Angle::createFromDecimal($decimal);
        $rounded_decimal = round($decimal, 1, RoundingMode::HalfTowardsZero);

        // Act & Assert
        $result = $angle->toDecimal();
        $this->assertIsFloat($result);
        $this->assertEquals($rounded_decimal, $result);
    }

    #[TestDox("can be casted to radian.")]
    public function test_cast_to_radiant()
    {
        // Arrange
        $precision = PHP_FLOAT_DIG;
        $radian = $this->faker->randomFloat(
            $precision,         /* Max available precision */
            -Angle::MAX_RADIAN, /* -360° */
            Angle::MAX_RADIAN   /* +360° */
        );
        $angle = Angle::createFromRadian($radian);
        $rounded_radian = round($radian, 1, RoundingMode::HalfTowardsZero);

        // Act & Assert
        $this->assertEquals($rounded_radian, $angle->toRadian(), $this->getCastError("radian"));
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
        $alfa->toggleDirection(); /* From positive to negative */
        $beta->toggleDirection(); /* From negative to positive */

        // Assert
        $failure_message_1 = "The angle should be counterclockwise but found the opposite.";
        $failure_message_2 = "The angle should be clockwise but found the opposite.";
        $this->assertEquals(Angle::CLOCKWISE, $alfa->direction, $failure_message_2);
        $this->assertEquals(Angle::COUNTER_CLOCKWISE, $beta->direction, $failure_message_1);
    }

    #[TestDox("can be tested if it is equal to another congruent string, integer, decimal or object angle.")]
    public function test_equal_comparison()
    {
        // Arrange
        $positive_alfa = $this->getRandomAngle();
        $positive_beta = clone $positive_alfa;
        $negative_gamma = clone $positive_beta;
        $negative_gamma->toggleDirection();
        
        // Act & Assert
        $this->assertAngleEqual($positive_alfa, $positive_beta);
        $this->assertAngleEqual($positive_alfa, $negative_gamma);
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
        $positive_alfa = Angle::createFromValues(90);
        // Get an angle less than $alfa.
        $positive_beta = Angle::createFromValues(45);
        // Get an negative angle less than $alfa.
        $negative_delta = clone $positive_beta;
        $negative_delta->toggleDirection();

        // Act & Assert
        $this->assertAngleGreaterThan($positive_alfa, $positive_beta);
        $this->assertAngleGreaterThan($positive_alfa, $negative_delta);
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
        $positive_alfa = Angle::createFromValues(90);
        $positive_beta = Angle::createFromValues(45);
        $negative_gamma = clone $positive_beta;
        $negative_gamma->toggleDirection();
        $delta_equal_to_alfa = clone $positive_alfa;
        
        // Act & Assert
        $this->assertAngleGreaterThanOrEqual($positive_alfa, $positive_beta);
        $this->assertAngleGreaterThanOrEqual($positive_alfa, $negative_gamma);
        $this->assertAngleGreaterThanOrEqual($positive_alfa, $delta_equal_to_alfa);
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
        $positive_alfa = Angle::createFromValues(45);
        $positive_beta = Angle::createFromValues(90);
        $negative_gamma = clone $positive_beta;
        $negative_gamma->toggleDirection();

        // Act & Assert
        $this->assertAngleLessThan($positive_alfa, $positive_beta);
        $this->assertAngleLessThan($positive_alfa, $negative_gamma);
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
        $positive_alfa = Angle::createFromValues(45);
        $positive_beta = Angle::createFromValues(90);
        $negative_delta = clone $positive_beta;
        $negative_delta->toggleDirection();
        $delta_equal_to_alfa = clone $positive_alfa;

        // Act & Assert
        $this->assertAngleLessThanOrEqual($positive_alfa, $positive_beta);
        $this->assertAngleLessThanOrEqual($positive_alfa, $negative_delta);
        $this->assertAngleLessThanOrEqual($positive_alfa, $delta_equal_to_alfa);
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
        $alfa = Angle::createFromValues(90);
        $beta = Angle::createFromValues(45);
        $gamma = clone $beta;
        $gamma->toggleDirection();

        // Act & Assert
        $this->assertAngleDifferent($alfa, $beta);
        $this->assertAngleDifferent($alfa, $gamma);
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

        // Act
        $gamma = Angle::sum($alfa, $beta);

        // Assert
        $decimal_alfa = $alfa->toDecimal(3);
        $decimal_beta = $beta->toDecimal(3);
        $decimal_gamma = $gamma->toDecimal();
        $decimal_sum = round($decimal_alfa + $decimal_beta, 1, RoundingMode::HalfTowardsZero);
        $absolute_sum = abs($decimal_sum);
        while ($absolute_sum > Angle::MAX_DEGREES) {
            $absolute_sum = round($absolute_sum - Angle::MAX_DEGREES, 1, RoundingMode::HalfTowardsZero);
        }
        $decimal_sum = $decimal_sum >= 0 ? $absolute_sum : -$absolute_sum;
        $this->assertEquals($decimal_sum, $decimal_gamma, 
            "{$decimal_alfa}° + {$decimal_beta}° must equals {$decimal_sum}° but found {$decimal_gamma}°."
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

    /**
     * Assert the passed $values are the same of $angle. 
     * This is a Custom Assertion.
     *
     * @param AngleInterface $angle The angle being tested.
     * @param array $values The expected values of the angle.
     * @return void
     */
    protected function assertAngleHaveValues(AngleInterface $angle, array $values)
    {
        $expected_values = $angle->getDegrees(true);
        $this->assertEquals($expected_values["degrees"], $values["degrees"]);
        $this->assertEquals($expected_values["minutes"], $values["minutes"]);
        $this->assertEquals($expected_values["seconds"], $values["seconds"]);
    }

    /**
     * Asserts $first_angle is greater than $second_angle. 
     * This is not a Custom Assertion but a Parameterized Test.
     *
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $first_angle
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $second_angle
     * @return void
     */
    protected function assertAngleGreaterThan(AngleInterface $first_angle, AngleInterface $second_angle, int $precision = 1)
    {
        $failure_message = $first_angle->toDecimal($precision) . " > " . $second_angle->toDecimal($precision) . " is false.";

        $this->assertTrue($first_angle->isGreaterThan((string) $second_angle),                  $failure_message);
        $this->assertTrue($first_angle->isGreaterThan($second_angle->toDecimal($precision)),    $failure_message);
        $this->assertTrue($first_angle->isGreaterThan((int) $second_angle->toDecimal(0)),       $failure_message);
        $this->assertTrue($first_angle->isGreaterThan($second_angle),                           $failure_message);
        $this->assertTrue($first_angle->gt((string) $second_angle),                             $failure_message);
        $this->assertTrue($first_angle->gt($second_angle->toDecimal($precision)),               $failure_message);
        $this->assertTrue($first_angle->gt((int) $second_angle->toDecimal(0)),                  $failure_message);
        $this->assertTrue($first_angle->gt($second_angle),                                      $failure_message);

        $this->assertFalse($second_angle->isGreaterThan((string) $first_angle),                 $failure_message);
        $this->assertFalse($second_angle->isGreaterThan($second_angle->toDecimal($precision)),  $failure_message);
        $this->assertFalse($second_angle->isGreaterThan((int) $second_angle->toDecimal(0)),     $failure_message);
        $this->assertFalse($second_angle->isGreaterThan($second_angle),                         $failure_message);
        $this->assertFalse($second_angle->gt((string) $first_angle),                            $failure_message);
        $this->assertFalse($second_angle->gt($second_angle->toDecimal($precision)),             $failure_message);
        $this->assertFalse($second_angle->gt((int) $second_angle->toDecimal(0)),                $failure_message);
        $this->assertFalse($second_angle->gt($second_angle),                                    $failure_message);
    }

    /**
     * Asserts $first_angle is greater than or equal to $second_angle. 
     * This is not a Custom Assertion but a Parameterized Test.
     *
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $first_angle
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $second_angle
     * @return void
     */
    protected function assertAngleGreaterThanOrEqual(AngleInterface $first_angle, AngleInterface $second_angle, int $precision = 1)
    {
        $failure_message = $first_angle->toDecimal($precision) . " >= " . $second_angle->toDecimal($precision) . " is false.";
        $this->assertTrue($first_angle->isGreaterThanOrEqual((string) $second_angle),               $failure_message);
        $this->assertTrue($first_angle->isGreaterThanOrEqual($second_angle->toDecimal($precision)), $failure_message);
        $this->assertTrue($first_angle->isGreaterThanOrEqual((int) $second_angle->toDecimal(0)),    $failure_message);
        $this->assertTrue($first_angle->isGreaterThanOrEqual($second_angle),                        $failure_message);
        $this->assertTrue($first_angle->gte((string) $second_angle),                                $failure_message);
        $this->assertTrue($first_angle->gte($second_angle->toDecimal($precision)),                  $failure_message);
        $this->assertTrue($first_angle->gte((int) $second_angle->toDecimal(0)),                     $failure_message);
        $this->assertTrue($first_angle->gte($second_angle),                                         $failure_message);

        $this->assertFalse($first_angle->isLessThan((string) $second_angle),                        $failure_message);
        $this->assertFalse($first_angle->isLessThan($second_angle->toDecimal($precision)),          $failure_message);
        $this->assertFalse($first_angle->isLessThan((int) $second_angle->toDecimal(0)),             $failure_message);
        $this->assertFalse($first_angle->isLessThan($second_angle),                                 $failure_message);
        $this->assertFalse($first_angle->lt((string) $second_angle),                                $failure_message);
        $this->assertFalse($first_angle->lt($second_angle->toDecimal($precision)),                  $failure_message);
        $this->assertFalse($first_angle->lt((int) $second_angle->toDecimal(0)),                     $failure_message);
        $this->assertFalse($first_angle->lt($second_angle),                                         $failure_message);
    }

    /**
     * Asserts $first_angle is equal to $second_angle. 
     * This is not a Custom Assertion but a Parameterized Test.
     *
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $first_angle
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $second_angle
     * @return void
     */
    protected function assertAngleEqual(AngleInterface $first_angle, AngleInterface $second_angle, int $precision = 1)
    {
        $failure_message = $first_angle->toDecimal($precision) . " == " . $second_angle->toDecimal($precision) . " is false.";
        $this->assertTrue($first_angle->isEqual((string) $second_angle),                $failure_message);
        $this->assertTrue($first_angle->isEqual($second_angle->toDecimal($precision)),  $failure_message);
        $this->assertTrue($first_angle->isEqual((int) $second_angle->toDecimal(0)),     $failure_message);
        $this->assertTrue($first_angle->isEqual($second_angle),                         $failure_message);
        $this->assertTrue($first_angle->eq((string) $second_angle),                     $failure_message);
        $this->assertTrue($first_angle->eq($second_angle->toDecimal($precision)),       $failure_message);
        $this->assertTrue($first_angle->eq((int) $second_angle->toDecimal(0)),          $failure_message);
        $this->assertTrue($first_angle->eq($second_angle),                              $failure_message);

        $this->assertFalse($first_angle->isDifferent((string) $second_angle),               $failure_message);
        $this->assertFalse($first_angle->isDifferent($second_angle->toDecimal($precision)), $failure_message);
        $this->assertFalse($first_angle->isDifferent((int) $second_angle->toDecimal(0)),    $failure_message);
        $this->assertFalse($first_angle->isDifferent($second_angle),                        $failure_message);
        $this->assertFalse($first_angle->not((string) $second_angle),                       $failure_message);
        $this->assertFalse($first_angle->not($second_angle->toDecimal($precision)),         $failure_message);
        $this->assertFalse($first_angle->not((int) $second_angle->toDecimal(0)),            $failure_message);
        $this->assertFalse($first_angle->not($second_angle),                                $failure_message);
    }

    /**
     * Asserts $first_angle is different than $second_angle.
     * This is not a Custom Assert but a Parameterized Test.
     *
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $first_angle
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $second_angle
     * @return void
     */
    public function assertAngleDifferent(AngleInterface $first_angle, AngleInterface $second_angle, int $precision = 1) {
        $failure_message = $first_angle->toDecimal($precision) . " != " . $second_angle->toDecimal($precision) . " is false.";
        $this->assertTrue($first_angle->isDifferent((string) $second_angle),                $failure_message);
        $this->assertTrue($first_angle->isDifferent($second_angle->toDecimal($precision)),  $failure_message);
        $this->assertTrue($first_angle->isDifferent((int) $second_angle->toDecimal(0)),     $failure_message);
        $this->assertTrue($first_angle->isDifferent($second_angle),                         $failure_message);
        $this->assertTrue($first_angle->not((string) $second_angle),                        $failure_message);
        $this->assertTrue($first_angle->not($second_angle->toDecimal($precision)),          $failure_message);
        $this->assertTrue($first_angle->not((int) $second_angle->toDecimal(0)),             $failure_message);
        $this->assertTrue($first_angle->not($second_angle),                                 $failure_message);

        $this->assertFalse($first_angle->isEqual((string) $second_angle),               $failure_message);
        $this->assertFalse($first_angle->isEqual($second_angle->toDecimal($precision)), $failure_message);
        $this->assertFalse($first_angle->isEqual((int) $second_angle->toDecimal(0)),    $failure_message);
        $this->assertFalse($first_angle->isEqual($second_angle),                        $failure_message);
        $this->assertFalse($first_angle->eq((string) $second_angle),                    $failure_message);
        $this->assertFalse($first_angle->eq($second_angle->toDecimal($precision)),      $failure_message);
        $this->assertFalse($first_angle->eq((int) $second_angle->toDecimal(0)),         $failure_message);
        $this->assertFalse($first_angle->eq($second_angle),                             $failure_message);
    }

    /**
     * Asserts that $first_angle is less than $second_angle.
     * This is not a Custom Assertion. This is a Parameterized Test.
     *
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $first_angle
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $second_angle
     * @return void
     */
    protected function assertAngleLessThan(AngleInterface $first_angle, AngleInterface $second_angle, int $precision = 1)
    {
        $failure_message = $first_angle->toDecimal($precision) . " < " . $second_angle->toDecimal($precision) . " is not true.";           
        $this->assertTrue($first_angle->isLessThan((string) $second_angle),               $failure_message);
        $this->assertTrue($first_angle->isLessThan($second_angle->toDecimal($precision)), $failure_message);
        $this->assertTrue($first_angle->isLessThan((int) $second_angle->toDecimal(0)),    $failure_message);
        $this->assertTrue($first_angle->isLessThan($second_angle),                        $failure_message);
        $this->assertTrue($first_angle->lt((string) $second_angle),                       $failure_message);
        $this->assertTrue($first_angle->lt($second_angle->toDecimal($precision)),         $failure_message);
        $this->assertTrue($first_angle->lt((int) $second_angle->toDecimal(0)),            $failure_message);
        $this->assertTrue($first_angle->lt($second_angle),                                $failure_message);

        $this->assertFalse($first_angle->isGreaterThanOrEqual((string) $second_angle),                  $failure_message);
        $this->assertFalse($first_angle->isGreaterThanOrEqual($second_angle->toDecimal($precision)),    $failure_message);
        $this->assertFalse($first_angle->isGreaterThanOrEqual((int) $second_angle->toDecimal(0)),       $failure_message);
        $this->assertFalse($first_angle->isGreaterThanOrEqual($second_angle),                           $failure_message);
        $this->assertFalse($first_angle->gte((string) $second_angle),                                   $failure_message);
        $this->assertFalse($first_angle->gte($second_angle->toDecimal($precision)),                     $failure_message);
        $this->assertFalse($first_angle->gte((int) $second_angle->toDecimal(0)),                        $failure_message);
        $this->assertFalse($first_angle->gte($second_angle),                                            $failure_message);
    }

    /**
     * Asserts $first_angle is less than or equal to $second_angle. 
     * This is not a Custom Assertion bu a Parameterized Test.
     *
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $first_angle
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $second_angle
     * @return void
     */
    protected function assertAngleLessThanOrEqual(AngleInterface $first_angle, AngleInterface $second_angle, int $precision = 1)
    {
        $failure_message = $first_angle->toDecimal($precision) . " <= " . $second_angle->toDecimal($precision);
        $this->assertTrue($first_angle->isLessThanOrEqual((string) $second_angle),                  $failure_message);
        $this->assertTrue($first_angle->isLessThanOrEqual($second_angle->toDecimal($precision)),    $failure_message);
        $this->assertTrue($first_angle->isLessThanOrEqual((int) $second_angle->toDecimal(0)),       $failure_message);
        $this->assertTrue($first_angle->isLessThanOrEqual($second_angle),                           $failure_message);
        $this->assertTrue($first_angle->lte((string) $second_angle),                                $failure_message);
        $this->assertTrue($first_angle->lte($second_angle->toDecimal($precision)),                  $failure_message);
        $this->assertTrue($first_angle->lte((int) $second_angle->toDecimal(0)),                     $failure_message);
        $this->assertTrue($first_angle->lte($second_angle),                                         $failure_message);

        $this->assertFalse($first_angle->isGreaterThan((string) $second_angle),                     $failure_message);
        $this->assertFalse($first_angle->isGreaterThan($second_angle->toDecimal($precision)),       $failure_message);
        $this->assertFalse($first_angle->isGreaterThan((int) $second_angle->toDecimal(0)),          $failure_message);
        $this->assertFalse($first_angle->isGreaterThan($second_angle),                              $failure_message);
        $this->assertFalse($first_angle->gt((string) $second_angle),                                $failure_message);
        $this->assertFalse($first_angle->gt($second_angle->toDecimal($precision)),                  $failure_message);
        $this->assertFalse($first_angle->gt((int) $second_angle->toDecimal(0)),                     $failure_message);
        $this->assertFalse($first_angle->gt($second_angle),                                         $failure_message);
    }
}