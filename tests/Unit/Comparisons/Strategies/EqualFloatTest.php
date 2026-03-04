<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualFloat;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\Feature\AngleTest;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DependsExternal;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The EqualFloat comparison strategy")]
#[CoversClass(EqualFloat::class)]
#[UsesClass(Angle::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class EqualFloatTest extends TestCase
{
    #[DependsExternal(AngleTest::class, "test_cast_to_decimal")]
    #[TestDox("can compare an Angle and a sexadecimal angle measure.")]
    public function test_compare(): void
    {
        /**
         * Equal
         */
        // Arrange
        $precision = $this->randomPrecision();
        $alfa = $this->randomAngle();
        $beta = $alfa->toDecimal($precision);
        $true_alfa = number_format($alfa->toDecimal($precision), PHP_FLOAT_DIG);
        $true_beta = number_format($beta, PHP_FLOAT_DIG);

        // Act & Assert
        $this->assertTrue(new EqualFloat($alfa, $beta, $precision)->compare(), 
            "\$alfa = $true_alfa\n\$beta = $true_beta"
        );

        /**
         * Not equal
         */
        // Arrange
        $alfa = $this->randomAngle(0, 180 - self::SSN);
        $beta = $this->randomSexadecimal(180);

        // Act & Assert
        $this->assertFalse(new EqualFloat($alfa, $beta, $precision)->compare());
    }
}