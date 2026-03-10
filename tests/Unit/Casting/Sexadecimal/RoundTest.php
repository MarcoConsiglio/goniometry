<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Casting\Sexadecimal;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The Round class")]
#[CoversClass(Round::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class RoundTest extends TestCase
{
    #[TestDox("can cast the Angle to a sexadecimal value with a specific precision.")]
    public function test_cast_with_precision(): void
    {
        /**
         * Less than PHP_FLOAT_DIG
         */
        // Arrange
        $precision = $this->positiveRandomInteger(max: PHP_FLOAT_DIG);
        $expected_float = $this->randomSexadecimal(precision: $precision);

        // Act
        $float = new Round($expected_float, $precision)->cast();

        // Assert
        $this->assertSame($expected_float, $float, "$expected_float ≠ $float with $precision digit precision");

        /**
         * More than PHP_FLOAT_DIG
         */
        // Arrange
        $precision = $this->positiveRandomInteger(min: PHP_FLOAT_DIG + 1);
        $expected_float = $this->randomSexadecimal(precision: $precision);

        // Act
        $float = new Round($expected_float, $precision)->cast();

        // Assert
        $this->assertSame($expected_float, $float, "$expected_float ≠ $float with $precision digit precision");
    }

    public function test_cast_without_precision(): void
    {
        // Arrange
        $expected_float = $this->randomSexadecimal(max: PHP_FLOAT_DIG);
        $angle = Angle::createFromDecimal($expected_float);

        // Act
        $float = new Round($expected_float)->cast();

        // Assert
        $this->assertSame($expected_float, $float, "$expected_float ≠ $float");
    }
}