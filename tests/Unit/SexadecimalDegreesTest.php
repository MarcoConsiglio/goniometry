<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesTrait;

#[TestDox("The SexadecimalDegrees class")]
#[CoversClass(SexadecimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
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
            $this->safeRound($value), 
            $sexadecimal->value->toFloat(self::PRECISION)
        );
    }

    #[TestDox("can store a negative sexadecimal value.")]
    public function test_negative_sexadecimal(): void
    {
        // Arrange
        $value = $this->negativeRandomSexadecimal();

        // Act
        $sexadecimal = new SexadecimalDegrees($value);

        // Assert
        $this->assertEquals(
            $this->safeRound($value),
            $sexadecimal->value->toFloat(self::PRECISION)
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