<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Casting\Sexadecimal;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Cast;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The Sexadecimal\Cast class")]
#[CoversClass(Cast::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalDegrees::class)]
class CastTest extends TestCase
{
    protected Angle $angle;

    protected SexadecimalDegrees $sexadecimal;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->angle = $this->randomAngle();
        $this->sexadecimal = $this->angle->toDecimal();
    }

    #[TestDox("can cast the Angle to a sexadecimal value with a specific precision.")]
    public function test_cast_with_precision(): void
    {
        // Arrange
        $precision = $this->randomPrecision();
        $sexadecimal = $this->sexadecimal->value->toFloat($precision);

        // Act
        $float = new Cast($this->angle, $precision)->cast();

        // Assert
        $this->assertSame($sexadecimal, $float, "$sexadecimal ≠ $float with $precision digit precision");
    }

    #[TestDox("can cast the Angle to a sexadecimal value without a specific precision.")]
    public function test_cast_without_precision(): void
    {
        // Arrange
        $sexadecimal = $this->sexadecimal->value->toFloat();

        // Act
        $float = new Cast($this->angle)->cast();

        // Assert
        $this->assertSame($sexadecimal, $float, "$sexadecimal ≠ $float");
    }

    #[TestDox("limits precision to PHP_FLOAT_DIG")]
    public function test_cast_with_excessive_precision(): void
    {
       // Arrange
        $precision = $this->randomPrecision() + 1;
        $sexadecimal = $this->sexadecimal->value->toFloat($precision);

        // Act
        $float = new Cast($this->angle, $precision)->cast();

        // Assert
        $this->assertSame($sexadecimal, $float, "$sexadecimal ≠ $float with $precision digit precision");
    }

    #[TestDox("limits precision to PHP_FLOAT_DIG")]
    public function test_cast_with_negative_precision(): void
    {
        // Arrange
        $precision = -($this->randomPrecision() + 1);
        $sexadecimal = $this->sexadecimal->value->toFloat($precision);

        // Act
        $float = new Cast($this->angle, $precision)->cast();

        // Assert
        $this->assertSame($sexadecimal, $float, 
            "$sexadecimal ≠ $float with $precision digit precision");
    }
}