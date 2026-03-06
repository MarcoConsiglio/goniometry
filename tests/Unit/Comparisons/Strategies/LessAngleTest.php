<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LessAngle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DependsOnClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The LessAngle comparison strategy")]
#[CoversClass(LessAngle::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class LessAngleTest extends TestCase
{
    #[DependsOnClass(GreaterAngleTest::class)]
    #[TestDox("can compare two Angle instances.")]
    public function test_compare(): void
    {
        /**
         * Lesser
         */
        // Arrange
        $alfa = $this->randomAngle(max: 180 - self::SSN);
        $beta = $this->randomAngle(min: 180);

        // Act & Assert
        $this->assertTrue(new LessAngle($alfa, $beta)->compare());

        /**
         * Equal
         */
        // Arrange
        $alfa = $this->randomAngle();
        $beta = clone $alfa;

        // Act & Assert
        $this->assertFalse(new LessAngle($alfa, $beta)->compare());

        /**
         * Greater
         */
        // Arrange
        $alfa = $this->randomAngle(min: 180);
        $beta = $this->randomAngle(max: 180 - self::SSN);

        // Act & Assert
        $this->assertFalse(new LessAngle($alfa, $beta)->compare());
    }
}