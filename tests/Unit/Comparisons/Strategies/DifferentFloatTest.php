<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\DifferentFloat;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualFloat;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DependsOnClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The DifferentFloat comparison strategy")]
#[CoversClass(DifferentFloat::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(EqualFloat::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class DifferentFloatTest extends TestCase
{
    #[DependsOnClass(EqualFloatTest::class)]
    #[TestDox("can compare an Angle and a sexadecimal angle measure.")]
    public function test_compare(): void
    {
        /**
         * Different
         */
        // Arrange
        $alfa = $this->randomAngle(0, 180 - self::SSN);
        $beta = $this->randomSexadecimal(min: 180, precision: 13);

        // Act & Assert
        $this->assertTrue(new DifferentFloat($alfa, $beta)->compare());

        /**
         * Equal
         */
        // Arrange
        $alfa = $this->randomAngle();
        $beta = (clone $alfa)->toDecimal();

        // Act & Assert
        $this->assertFalse(new DifferentFloat($alfa, $beta)->compare());
    }
}