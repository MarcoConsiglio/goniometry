<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit;

use InvalidArgumentException;
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
use ReflectionClass;
use RoundingMode;

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
// #[UsesClass(InvalidArgumentException::class)]
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

    #[TestDox("can be created from a text representation.")]
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

    #[TestDox("can be created from a radiant number.")]
    public function test_create_from_radiant()
    {
        // Arrange
        $precision = 5;
        $radiant = $this->faker->randomFloat($precision, -Angle::MAX_RADIAN, Angle::MAX_RADIAN);

        // Act
        $angle = Angle::createFromRadian($radiant);

        // Assert
        $this->assertEquals($radiant, $angle->toRadian($precision));
    }

    #[TestDox("can output degrees, minutes and seconds wrapped in a simple array.")]
    public function test_get_angle_values_in_simple_array()
    {
        // Arrange
        /** @var \MarcoConsiglio\Goniometry\Angle&\PHPUnit\Framework\MockObject\MockObject $alfa */
        $alfa = $this->getMockedAngle();
        $this->setAngleProperties($alfa, [1, 2, 3.4]);

        // Act
        $result = $alfa->getDegrees();

        // Assert
        $failure_message = "Can't get angle values as a simple array.";
        $this->assertEquals(1,   $result[0], $failure_message);
        $this->assertEquals(2,   $result[1], $failure_message);
        $this->assertEquals(3.4, $result[2], $failure_message);
    }

    #[TestDox("can output degrees, minutes and seconds wrapped in an associative array.")]
    public function test_get_angle_values_in_assoc_array()
    {
        // Arrange
        /** @var \MarcoConsiglio\Goniometry\Angle&\PHPUnit\Framework\MockObject\MockObject $alfa */
        $alfa = $this->getMockedAngle();
        $this->setAngleProperties($alfa, [1, 2, 3.4]);

        // Act
        $result = $alfa->getDegrees(associative: true);

        // Assert
        $failure_message = "Can't get angle values as a simple array.";
        $this->assertEquals(1,   $result["degrees"], $failure_message);
        $this->assertEquals(2,   $result["minutes"], $failure_message);
        $this->assertEquals(3.4, $result["seconds"], $failure_message);
    }

    #[TestDox("can be printed in a positive textual representation.")]
    public function test_can_cast_positive_angle_to_string()
    {
        // Arrange
        /** @var \MarcoConsiglio\Goniometry\Angle&\PHPUnit\Framework\MockObject\MockObject $alfa */
        $alfa = $this->getMockedAngle(["isCounterClockwise"]);
        $alfa->expects($this->anyTime())->method("isCounterClockwise")->willReturn(false);

        $this->setAngleProperties($alfa, [1, 2, 3.4]);
        $expected_string = "1° 2' 3.4\"";

        // Act & Assert
        $this->assertEquals($expected_string, (string) $alfa, $this->getCastError("string"));
    }
    
    #[TestDox("can be printed in a negative textual representation.")]
    public function test_can_cast_negative_angle_to_string()
    {
        // Arrange
        /** @var \MarcoConsiglio\Goniometry\Angle&\PHPUnit\Framework\MockObject\MockObject $alfa */
        $alfa = $this->getMockedAngle(["isClockwise"]);
        $alfa->expects($this->anyTime())->method("isClockwise")->willReturn(true);
        $this->setAngleProperties($alfa, [1, 2, 3.4, Angle::CLOCKWISE]);
        $expected_string = "-1° 2' 3.4\"";

        // Act & Assert
        $this->assertEquals($expected_string, (string) $alfa, $this->getCastError("string"));
    }

    #[TestDox("can be casted to decimal.")]
    public function test_can_cast_to_decimal()
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

    #[TestDox("can be casted to radiant.")]
    public function test_cast_to_radiant()
    {
        // Arrange
        $precision = 5;
        $radiant = $this->faker->randomFloat($precision, -Angle::MAX_RADIAN, Angle::MAX_RADIAN);
        $angle = Angle::createFromRadian($radiant);

        // Act & Assert
        $this->assertEquals($radiant, $angle->toRadian($precision), $this->getCastError("radiant"));
    }

    #[TestDox("can be clockwise or negative.")]
    public function test_angle_is_clockwise()
    {
        // Arrange
        /** @var \MarcoConsiglio\Goniometry\Angle&\PHPUnit\Framework\MockObject\MockObject $alfa */
        $alfa = $this->getMockedAngle();
        $this->setAngleProperties($alfa, [1, 0, 0, Angle::CLOCKWISE]);

        // Act & assert
        $this->assertTrue($alfa->isClockwise(), "The angle is clockwise but found the opposite.");
    }

    #[TestDox("can be counterclockwise or positive.")]
    public function test_angle_is_counterclockwise()
    {
        // Arrange
        /** @var \MarcoConsiglio\Goniometry\Angle&\PHPUnit\Framework\MockObject\MockObject $alfa */
        $alfa = $this->getMockedAngle();

        // Act & assert
        $this->assertTrue($alfa->isCounterClockwise(), "The angle is clockwise but found the opposite.");
    }

    #[TestDox("can be reversed from counterclockwise to clockwise.")]
    public function test_can_toggle_rotation_from_clockwise_to_counterclockwise()
    {
        // Arrange
        /** @var \MarcoConsiglio\Goniometry\Angle&\PHPUnit\Framework\MockObject\MockObject $alfa */
        $alfa = $this->getMockedAngle([]);
        $this->setAngleProperties($alfa, [1, 2, 3.4]);

        // Act
        $alfa->toggleDirection();

        // Assert
        $failure_message = "The angle should be counterclockwise but found the opposite";
        $this->assertEquals(Angle::CLOCKWISE, $alfa->direction, $failure_message);
    }

    #[TestDox("can be reversed from clockwise to counterclockwise.")]
    public function test_can_toggle_rotation_from_counterclockwise_to_clockwise()
    {
        // Arrange
        /** @var \MarcoConsiglio\Goniometry\Angle&\PHPUnit\Framework\MockObject\MockObject $alfa */
        $alfa = $this->getMockedAngle();
        $this->setAngleProperties($alfa, [1, 2, 3.4, Angle::COUNTER_CLOCKWISE]);

        // Act
        $alfa->toggleDirection();

        // Assert
        $failure_message = "The angle should be clockwise but found the opposite.";
        $this->assertEquals(Angle::CLOCKWISE, $alfa->direction, $failure_message);
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

        // Act & Assert
        $invalid_argument = true;
        $alfa->expects($this->never())->method("toDecimal");
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($this->getInvalidArgumentMessage(
            $invalid_argument, ["int", "float", "string", Angle::class], Angle::class."::isEqual", 1
        ));
        $alfa->eq($invalid_argument);
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
        
        // Act & Assert
        $invalid_argument = true;
        $alfa->expects($this->never())->method("toDecimal");
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($this->getInvalidArgumentMessage($invalid_argument, 
            ["int", "float", "string", Angle::class], Angle::class."::isGreaterThan", 1)
        );
        $alfa->gt($invalid_argument); // Two birds with one stone.
    }

    #[TestDox("can be tested if it is greater than or equal another string, decimal or object angle.")]
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
    }

    #[TestDox("throws an exception if greater than or equal comparison has an unexpected type argument.")]
    public function test_greater_than_or_equal_comparison_exception()
    {
        // Arrange
        /** @var \MarcoConsiglio\Goniometry\Angle&\PHPUnit\Framework\MockObject\MockObject $alfa  */
        $alfa = $this->getMockedAngle(["toDecimal"]);
        
        // Act & Assert
        $invalid_argument = true;
        $alfa->expects($this->never())->method("toDecimal");
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($this->getInvalidArgumentMessage($invalid_argument, 
            ["int", "float", "string", Angle::class], Angle::class."::isGreaterThanOrEqual", 1)
        );
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

        // Act & Assert
        $invalid_argument = true;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($this->getInvalidArgumentMessage($invalid_argument, 
            ["int", "float", "string", Angle::class], Angle::class."::isLessThan", 1)
        );
        $alfa->lt($invalid_argument); // Two birds with one stone.
    }

    #[TestDox("can be tested if it is less than or equal another string, decimal or object angle.")]
    public function test_less_than_or_equal_comparison()
    {
        // Arrange
        $positive_alfa = Angle::createFromValues(45);
        $positive_beta = Angle::createFromValues(90);
        $negative_delta = clone $positive_beta;
        $negative_delta->toggleDirection();

        // Act & Assert
        $this->assertAngleLessThanOrEqual($positive_alfa, $positive_beta);
        $this->assertAngleLessThanOrEqual($positive_alfa, $negative_delta);
    }

    #[TestDox("throws an exception if less than or equal comparison has an unexpected type.")]
    public function test_invalid_argument_exception()
    {
        // Arrange
        /** @var \MarcoConsiglio\Goniometry\Angle&\PHPUnit\Framework\MockObject\MockObject $alfa */
        $alfa = $this->getMockedAngle(["toDecimal"]);
        $alfa->expects($this->never())->method("toDecimal");
        
        // Act & Assert
        $invalid_argument = true;
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($this->getInvalidArgumentMessage($invalid_argument, 
            ["int", "float", "string", Angle::class], Angle::class."::isLessThanOrEqual", 1)
        );
        $alfa->lte($invalid_argument); // Two birds with one stone.
    }

    /**
     * Gets an invalid argument message fixture.
     *
     * @param mixed   $argument
     * @param array   $expected_types
     * @param string  $method
     * @param integer $parameter_position
     * @return string
     */
    protected function getInvalidArgumentMessage(mixed $argument, array $expected_types, string $method, int $parameter_position): string
    {
        $last_type = "";
        $total_types = count($expected_types);
        if ($total_types >= 2) {
            $last_type = " or ".$expected_types[$total_types - 1];
            unset($expected_types[$total_types - 1]);
        }
        return "$method method expects parameter $parameter_position to be ".implode(", ", $expected_types).$last_type.", but found ".gettype($argument);
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
     * Asserts $first_angle is greater than $second_angle. 
     * This is not a Custom Assertion but a Parameterized Test.
     *
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $first_angle
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $second_angle
     * @return void
     */
    protected function assertAngleGreaterThan(AngleInterface $first_angle, AngleInterface $second_angle)
    {
        $failure_message = $first_angle->toDecimal() . " > " . $second_angle->toDecimal();

        $this->assertTrue($first_angle->isGreaterThan((string) $second_angle->toDecimal()));
        $this->assertTrue($first_angle->isGreaterThan($second_angle->toDecimal()));
        $this->assertTrue($first_angle->isGreaterThan($second_angle));
        $this->assertTrue($first_angle->gt((string) $second_angle->toDecimal()));
        $this->assertTrue($first_angle->gt($second_angle->toDecimal()));
        $this->assertTrue($first_angle->gt($second_angle));

        $this->assertFalse($second_angle->isGreaterThan((string) $first_angle->toDecimal()));
        $this->assertFalse($second_angle->isGreaterThan($second_angle->toDecimal()));
        $this->assertFalse($second_angle->isGreaterThan($second_angle));
        $this->assertFalse($second_angle->gt((string) $first_angle->toDecimal()));
        $this->assertFalse($second_angle->gt($second_angle->toDecimal()));
        $this->assertFalse($second_angle->gt($second_angle));
    }

    /**
     * Asserts $first_angle is greater than or equal to $second_angle. 
     * This is not a Custom Assertion but a Parameterized Test.
     *
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $first_angle
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $second_angle
     * @return void
     */
    protected function assertAngleGreaterThanOrEqual(AngleInterface $first_angle, AngleInterface $second_angle)
    {
        $failure_message = $first_angle->toDecimal() . " >= " . $second_angle->toDecimal() . " is false.";
        $this->assertTrue($first_angle->isGreaterThanOrEqual((string) $second_angle->toDecimal()),  $failure_message);
        $this->assertTrue($first_angle->isGreaterThanOrEqual($second_angle->toDecimal()),           $failure_message);
        $this->assertTrue($first_angle->isGreaterThanOrEqual($second_angle),                        $failure_message);
        $this->assertTrue($first_angle->gte((string) $second_angle->toDecimal()),                   $failure_message);
        $this->assertTrue($first_angle->gte($second_angle->toDecimal()),                            $failure_message);
        $this->assertTrue($first_angle->gte($second_angle),                                         $failure_message);
    }

    /**
     * Asserts $first_angle is equal to $second_angle. 
     * This is not a Custom Assertion but a Parameterized Test.
     *
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $first_angle
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $second_angle
     * @return void
     */
    protected function assertAngleEqual(AngleInterface $first_angle, AngleInterface $second_angle)
    {
        $failure_message = $first_angle->toDecimal() . " == " . $second_angle->toDecimal() . " is false.";
        $this->assertTrue($first_angle->isEqual((string) $second_angle->toDecimal()),   $failure_message);
        $this->assertTrue($first_angle->isEqual($second_angle->toDecimal()),            $failure_message);
        $this->assertTrue($first_angle->isEqual($second_angle),                         $failure_message);
        $this->assertTrue($first_angle->eq((string) $second_angle->toDecimal()),        $failure_message);
        $this->assertTrue($first_angle->eq($second_angle->toDecimal()),                 $failure_message);
        $this->assertTrue($first_angle->eq($second_angle),                              $failure_message);
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
     * Asserts that $first_angle is less than $second_angle.
     * This is not a Custom Assertion. This is a Parameterized Test.
     *
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $first_angle
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $second_angle
     * @return void
     */
    protected function assertAngleLessThan(AngleInterface $first_angle, AngleInterface $second_angle)
    {
        $failure_message = $first_angle->toDecimal() . " < " . $second_angle->toDecimal() . " is not true.";           
        $this->assertTrue($first_angle->isLessThan((string) $second_angle),     $failure_message);
        $this->assertTrue($first_angle->isLessThan($second_angle->toDecimal()), $failure_message);
        $this->assertTrue($first_angle->isLessThan($second_angle),              $failure_message);
        $this->assertTrue($first_angle->lt((string) $second_angle->toDecimal()),$failure_message);
        $this->assertTrue($first_angle->lt($second_angle->toDecimal()),         $failure_message);
        $this->assertTrue($first_angle->lt($second_angle),                      $failure_message);
    }

    /**
     * Asserts that $first_angle is NOT less than $second_angle.
     * This is not a Custom Assertion but a Parameterized Test.
     *
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $first_angle
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $second_angle
     * @return void
     */
    protected function assertAngleNotLessThan(AngleInterface $first_angle, AngleInterface $second_angle)
    {
        $failure_message = $first_angle->toDecimal() . " >= " . $second_angle->toDecimal();           
        $this->assertFalse($first_angle->isLessThan((string) $second_angle->toDecimal()), $failure_message);
        $this->assertFalse($first_angle->isLessThan($second_angle->toDecimal()),          $failure_message);
        $this->assertFalse($first_angle->isLessThan($second_angle),                       $failure_message);
        $this->assertFalse($first_angle->lt((string) $second_angle->toDecimal()),         $failure_message);
        $this->assertFalse($first_angle->lt($second_angle->toDecimal()),                  $failure_message);
        $this->assertFalse($first_angle->lt($second_angle),                               $failure_message);
    }

    /**
     * Asserts $first_angle is less than or equal to $second_angle. This is not a Custom Assertion bu a Parameterized Test.
     *
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $first_angle
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $second_angle
     * @return void
     */
    protected function assertAngleLessThanOrEqual(AngleInterface $first_angle, AngleInterface $second_angle)
    {
        $failure_message = $first_angle->toDecimal() . " <= " . $second_angle->toDecimal();
        $this->assertTrue($first_angle->isLessThanOrEqual((string) $second_angle->toDecimal()),  $failure_message);
        $this->assertTrue($first_angle->isLessThanOrEqual($second_angle->toDecimal()),           $failure_message);
        $this->assertTrue($first_angle->isLessThanOrEqual($second_angle),                        $failure_message);
        $this->assertTrue($first_angle->lte((string) $second_angle->toDecimal()),                $failure_message);
        $this->assertTrue($first_angle->lte($second_angle->toDecimal()),                         $failure_message);
        $this->assertTrue($first_angle->lte($second_angle),                                      $failure_message);
    }
}