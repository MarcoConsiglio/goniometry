<?php
namespace MarcoConsiglio\Goniometry\Tests\Feature;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use RoundingMode;

#[TestDox("The SexadecimalDegrees class")]
#[CoversClass(SexadecimalDegrees::class)]
class SexadecimalDegreesTest extends TestCase
{
    #[TestDox("can store a positive sexadecimal value.")]
    public function test_positive_sexadecimal(): void
    {
        // Arrange
        $value = $this->positiveRandomSexadecimal();

        // Act
        $sexadecimal = new SexadecimalDegrees($value);

        // Assert
        $this->assertEquals(
            $value, $actual = $sexadecimal->value->toFloat(),
            "$value ≠ $actual"    
        );
    }

    #[TestDox("can store a negative sexadecimal value.")]
    public function test_negative_sexadecimal(): void
    {
        // Arrange
        $precision = PHP_FLOAT_DIG - 2;
        $value = $this->negativeRandomSexadecimal();

        // Act
        $sexadecimal = new SexadecimalDegrees($value);

        // Assert
        $this->assertEquals(
            round($value, $precision, RoundingMode::HalfTowardsZero), 
            round($actual = $sexadecimal->value->toFloat(), $precision, RoundingMode::HalfTowardsZero),
            "$value ≠ $actual"    
        );       
    }

    public function test_cast_to_string(): void
    {
        // Arrange
        $value = $this->randomSexadecimal();
        $sexadecimal = new SexadecimalDegrees($value);
        $expected_value = new Number($value);

        // Act
        $this->assertSame("{$expected_value}°", "$sexadecimal");       
    }
}