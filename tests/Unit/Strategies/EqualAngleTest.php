<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The EqualAngle comparison strategy")]
#[CoversClass(EqualAngle::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class EqualAngleTest extends TestCase
{
    #[TestDox("can compare if two Angle instances are equal.")]
    public function test_compare(): void
    {
        /**
         * Two equal Angle(s).
         */
        // Arrange
        $alfa = $this->randomAngle();
        $beta = clone $alfa;

        // Act & Assert
        $this->assertTrue(new EqualAngle($alfa, $beta)->compare());

        /**
         * Two different Angle(s).
         */
        $alfa = $this->randomAngle(max: 180 - PHP_FLOAT_MIN);
        $beta = $this->randomAngle(min: 180);

        // Act & Assert
        $this->assertFalse(new EqualAngle($alfa, $beta)->compare());
    }
}