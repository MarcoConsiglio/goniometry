<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\DifferentAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DependsOnClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The DifferentAngle comparison strategy")]
#[CoversClass(DifferentAngle::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class DifferentAngleTest extends TestCase
{
    #[DependsOnClass(EqualAngle::class)]
    #[TestDox("can compare two Angle instances.")]
    public function test_compare(): void
    {
        /**
         * Different
         */
        // Arrange
        $alfa = $this->randomAngle(max: 180 - self::SSN);
        $beta = $this->randomAngle(min: 180);

        // Act & Assert
        $this->assertTrue(new DifferentAngle($alfa, $beta)->compare());
        /**
         * Equal
         */
        $alfa = $this->randomAngle();
        $beta = clone $alfa;

        // Act & Assert
        $this->assertFalse(new DifferentAngle($alfa, $beta)->compare());
    }
}