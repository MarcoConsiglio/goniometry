<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualString;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DependsOnClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The EqualString comparison strategy")]
#[CoversClass(EqualString::class)]
#[UsesClass(Angle::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(FromString::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class EqualStringTest extends TestCase
{
    #[DependsOnClass(EqualAngleTest::class)]
    #[TestDox("can compare an Angle and a string angle.")]
    public function test_compare(): void
    {
        /**
         * Equal
         */
        // Arrange
        $alfa = $this->randomAngle();
        $beta = (string) $alfa;

        // Act & Assert
        $this->assertTrue(new EqualString($alfa, $beta)->compare());

        /**
         * Not equal
         */
        // Arrange
        $alfa = $this->randomAngle();
        $beta = (string) $this->randomAngle();

        // Act & Assert
        $this->assertFalse(new EqualString($alfa, $beta)->compare());
    }
}