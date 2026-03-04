<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\Feature\AngleTest;
use MarcoConsiglio\Goniometry\Tests\Feature\DegreesTest;
use MarcoConsiglio\Goniometry\Tests\Feature\MinutesTest;
use MarcoConsiglio\Goniometry\Tests\Feature\SecondsTest;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DependsExternal;
use PHPUnit\Framework\Attributes\DependsOnClass;
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
    #[DependsOnClass(DegreesTest::class)]
    #[DependsOnClass(MinutesTest::class)]
    #[DependsOnClass(SecondsTest::class)]
    #[DependsExternal(AngleTest::class, "test_degrees_property")]
    #[DependsExternal(AngleTest::class, "test_minutes_property")]
    #[DependsExternal(AngleTest::class, "test_seconds_property")]
    #[DependsExternal(AngleTest::class, "test_direction_property")]
    #[TestDox("can compare two Angle instances.")]
    public function test_compare(): void
    {
        /**
         * Equal
         */
        // Arrange
        $alfa = $this->randomAngle();
        $beta = clone $alfa;

        // Act & Assert
        $this->assertTrue(new EqualAngle($alfa, $beta)->compare());

        /**
         * Not equal
         */
        $alfa = $this->randomAngle(max: 180 - PHP_FLOAT_MIN);
        $beta = $this->randomAngle(min: 180);

        // Act & Assert
        $this->assertFalse(new EqualAngle($alfa, $beta)->compare());
    }
}