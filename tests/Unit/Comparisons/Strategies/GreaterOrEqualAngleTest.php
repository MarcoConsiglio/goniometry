<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterOrEqualAngle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DependsExternal;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The GreaterOrEqual comparison strategy")]
#[CoversClass(GreaterOrEqualAngle::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(GreaterAngle::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class GreaterOrEqualAngleTest extends TestCase
{
    #[DependsExternal(GreaterAngleTest::class)]
    #[DependsExternal(EqualAngleTest::class)]
    #[TestDox("can compare two Angle instances.")]
    public function test_compare(): void
    {
        /**
         * Greater
         */
        // Arrange
        $alfa = $this->randomAngle(min: 180);
        $beta = $this->randomAngle(max: 180 - self::SSN);

        // Act & Assert
        $this->assertTrue(new GreaterOrEqualAngle($alfa, $beta)->compare());

        /**
         * Equal
         */
        // Arrange
        $alfa = $this->randomAngle();
        $beta = clone $alfa;

        // Act & Assert
        $this->assertTrue(new GreaterOrEqualAngle($alfa, $beta)->compare());

        /**
         * Lesser
         */
        // Arrange
        $alfa = $this->randomAngle(max: 180 - self::SSN);
        $beta = $this->randomAngle(min: 180);

        // Act & Assert
        $this->assertFalse(new GreaterOrEqualAngle($alfa, $beta)->compare());
    }
}