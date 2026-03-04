<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\DifferentAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\DifferentString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The DifferentString comparison strategy")]
#[CoversClass(DifferentString::class)]
#[UsesClass(Angle::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(DifferentAngle::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(FromString::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class DifferentStringTest extends TestCase
{
    public function test_compare(): void
    {
        /**
         * Different
         */
        // Arrange
        $alfa = $this->randomAngle(min: 180);
        $beta = (string) $this->randomAngle(max: 180 - self::SSN);

        // Act & Assert
        $this->assertTrue(new DifferentString($alfa, $beta)->compare());

        /**
         * Equal
         */
        // Arrange
        $alfa = $this->randomAngle();
        $beta = (string) clone $alfa;
        
        // Act & Assert
        $this->assertFalse(new DifferentString($alfa, $beta)->compare());
    }
}