<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Casting\Sexadecimal;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Cast;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The Cast class")]
#[CoversClass(Cast::class)]
#[CoversClass(Angle::class)]
#[CoversClass(FromDegrees::class)]
#[CoversClass(Degrees::class)]
#[CoversClass(Minutes::class)]
#[CoversClass(Seconds::class)]
class CastTest extends TestCase
{
    protected Angle $angle;

    protected Number $expected_float;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        [$degrees, 
         $minutes, 
         $seconds, 
         $direction
        ] = $this->randomSexagesimal();
        $this->angle = Angle::createFromValues(
            $degrees,
            $minutes,
            $seconds,
            $direction
        );
        $this->expected_float = 
            $this->angle->degrees->value->plus(
                $this->angle->minutes->value->div(Minutes::MAX)
            )->plus(
                $this->angle->seconds->value->div(
                    Minutes::MAX * Seconds::MAX
                )
            )->mul($this->angle->direction->value);
    }

    #[TestDox("can cast the Angle to a sexadecimal value with a specific precision.")]
    public function test_cast_with_precision(): void
    {
        // Arrange
        $precision = $this->positiveRandomInteger(max: PHP_FLOAT_DIG);
        $expected_float = $this->expected_float->toFloat($precision);

        // Act
        $float = new Cast(
            $this->angle->degrees,
            $this->angle->minutes,
            $this->angle->seconds,
            $this->angle->direction,
            $precision
        )->cast();

        // Assert
        $this->assertSame($expected_float, $float, "$expected_float ≠ $float with $precision digit precision");
    }

    #[TestDox("can cast the Angle to a sexadecimal value without a specific precision.")]
    public function test_cast_without_precision(): void
    {
        // Arrange
        $expected_float = $this->expected_float->toFloat();

        // Act
        $float = new Cast(
            $this->angle->degrees,
            $this->angle->minutes,
            $this->angle->seconds,
            $this->angle->direction
        )->cast();

        // Assert
        $this->assertSame($expected_float, $float, "$expected_float ≠ $float");
    }

    #[TestDox("limits precision to PHP_FLOAT_DIG")]
    public function test_cast_with_excessive_precision(): void
    {
       // Arrange
        $precision = $this->positiveRandomInteger(min: PHP_FLOAT_DIG + 1);
        $expected_float = $this->expected_float->toFloat($precision);

        // Act
        $float = new Cast(
            $this->angle->degrees,
            $this->angle->minutes,
            $this->angle->seconds,
            $this->angle->direction,
            $precision
        )->cast();

        // Assert
        $this->assertSame($expected_float, $float, "$expected_float ≠ $float with $precision digit precision");
    }

    #[TestDox("limits precision to PHP_FLOAT_DIG")]
    public function test_cast_with_negative_precision(): void
    {
        /**
         * More than PHP_FLOAT_DIG
         */
        // Arrange
        $precision = $this->negativeRandomInteger(min: PHP_FLOAT_DIG + 1);
        $expected_float = $this->expected_float->toFloat();

        // Act
        $float = new Cast(
            $this->angle->degrees,
            $this->angle->minutes,
            $this->angle->seconds,
            $this->angle->direction,
            $precision
        )->cast();

        // Assert
        $this->assertSame($expected_float, $float, 
            "$expected_float ≠ $float with $precision digit precision");

        /**
         * Less than PHP_FLOAT_DIG
         */
        // Arrange
        $precision = $this->negativeRandomInteger(max: PHP_FLOAT_DIG);
        $expected_float = $this->expected_float->toFloat(abs($precision));

        // Act
        $float = new Cast(
            $this->angle->degrees,
            $this->angle->minutes,
            $this->angle->seconds,
            $this->angle->direction,
            $precision
        )->cast();

        // Assert
        $this->assertSame($expected_float, $float, 
            "$expected_float ≠ $float with $precision digit precision");
    }
}