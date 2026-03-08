<?php declare(strict_types=1);
namespace MarcoConsiglio\Goniometry\Tests\Unit;

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
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
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
        $alfa = $this->getMockedAngle(["toFloat"]);
        $alfa->expects($this->never())->method("toFloat");
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
        $alfa = $this->getMockedAngle(["toFloat"]);
        $alfa->expects($this->never())->method("toFloat");
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
        $alfa = $this->getMockedAngle(["toFloat"]);
        $alfa->expects($this->never())->method("toFloat");
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
        $alfa = $this->getMockedAngle(["toFloat"]);
        $alfa->expects($this->never())->method("toFloat");
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
        $alfa = $this->getMockedAngle(["toFloat"]);
        $alfa->expects($this->never())->method("toFloat");
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
        $alfa = $this->getMockedAngle(["toFloat"]);
        $alfa->expects($this->never())->method("toFloat");
        $invalid_argument = true;
        
        // Act & Assert
        $this->expectException(TypeError::class);
        $alfa->not($invalid_argument); // Two birds with one stone.
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
        $this->assertTrue($first_angle->gt($second_angle->toFloat($precision), $precision),  $failure_message);
        $this->assertTrue($first_angle->gt($second_angle),                                     $failure_message);
        
        $this->assertFalse($first_angle->lte((string) $second_angle),                           $failure_message);
        $this->assertFalse($first_angle->lte($second_angle->toFloat($precision), $precision), $failure_message);
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
        $this->assertTrue($first_angle->gte($second_angle->toFloat($precision)), $failure_message_false);
        $this->assertTrue($first_angle->gte($second_angle),                        $failure_message_false);
        
        $this->assertFalse($first_angle->lt((string) $second_angle),               $failure_message_true);
        $this->assertFalse($first_angle->lt($second_angle->toFloat($precision)), $failure_message_true);
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
        $this->assertTrue($first_angle->not($second_angle->toFloat($precision)), $failure_message_false);
        $this->assertTrue($first_angle->not($second_angle),                        $failure_message_false);
        
        $this->assertFalse($first_angle->eq((string) $second_angle),               $failure_message_true);
        $this->assertFalse($first_angle->eq($second_angle->toFloat($precision)), $failure_message_true);
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
        $this->assertTrue($first_angle->lt($second_angle->toFloat($precision)),   $failure_message_false);
        $this->assertTrue($first_angle->lt($second_angle),                          $failure_message_false);
        
        $this->assertFalse($first_angle->gte((string) $second_angle),               $failure_message_true);
        $this->assertFalse($first_angle->gte($second_angle->toFloat($precision)), $failure_message_true);
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
        $this->assertTrue($first_angle->lte($second_angle->toFloat($precision)), $failure_message_false);
        $this->assertTrue($first_angle->lte($second_angle),                        $failure_message_false);
        $this->assertFalse($first_angle->gt((string) $second_angle),               $failure_message_true);
        $this->assertFalse($first_angle->gt($second_angle->toFloat($precision)), $failure_message_true);
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