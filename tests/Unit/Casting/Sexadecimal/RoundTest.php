<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Casting\Sexadecimal;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use RoundingMode;

#[TestDox("The Round class")]
#[CoversClass(Round::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalDegrees::class)]
class RoundTest extends TestCase
{

    #[TestDox("can cast the Angle to a sexadecimal value with a specific precision.")]
    public function test_cast_with_precision(): void
    {
        /**
         * Less than PHP_FLOAT_DIG
         */
        // Arrange
        $precision = $this->randomPrecision();
        $sexadecimal = new SexadecimalDegrees(
            $this->randomSexadecimal(precision: $precision)
        );
        $expected_float = $sexadecimal->value->toFloat($precision);

        // Act
        $float = new Round($sexadecimal, $precision)->cast();

        // Assert
        $this->assertSame(
            $this->safeRound($expected_float), 
            $this->safeRound($float), 
            "Precision $precision"
        );

        /**
         * More than PHP_FLOAT_DIG
         */
        // Arrange
        $precision = PHP_FLOAT_DIG + 1;
        $expected_float = $this->randomSexadecimal(precision: $precision);
        $sexadecimal = new SexadecimalDegrees($expected_float);

        // Act
        $float = new Round($sexadecimal, $precision)->cast();

        // Assert
        $this->assertSame(
            $this->safeRound($expected_float), 
            $this->safeRound($float), 
            "Precision: $precision"
        );
    }

    #[TestDox("can cast the Angle to a sexadecimal value without a specific precision.")]
    public function test_cast_without_precision(): void
    {
        // Arrange
        $precision = PHP_FLOAT_DIG - 2;
        $expected_float = $this->randomSexadecimal();
        $sexadecimal = new SexadecimalDegrees($expected_float);

        // Act
        $float = new Round($sexadecimal)->cast();

        // Assert
        $this->assertSame(
            $this->safeRound($expected_float), 
            $this->safeRound($float)
        );
    }
}