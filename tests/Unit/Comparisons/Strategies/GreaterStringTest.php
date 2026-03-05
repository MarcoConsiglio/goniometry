<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterString;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\Feature\AngleTest;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DependsExternal;
use PHPUnit\Framework\Attributes\DependsOnClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The GreaterString comparison strategy")]
#[CoversClass(GreaterString::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(FromString::class)]
#[UsesClass(GreaterAngle::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class GreaterStringTest extends TestCase
{
    #[DependsExternal(AngleTest::class, "test_create_from_string")]
    #[DependsOnClass(GreaterAngle::class)]
    #[TestDox("can compare an Angle and a sexagesimal string angle measure.")]
    public function test_compare(): void
    {
        /**
         * Greater
         */
        // Arrange
        $alfa = $this->randomAngle(min: 180);
        $beta = (string) $this->randomAngle(max: 180 - self::SSN);

        // Act & Assert
        $this->assertTrue(new GreaterString($alfa, $beta)->compare());

        /**
         * Lesser
         */
        // Arrange
        $alfa = $this->randomAngle(max: 180 - self::SSN);
        $beta = (string) $this->randomAngle(min: 180);

        // Act & Assert
        $this->assertFalse(new GreaterString($alfa, $beta)->compare());

        /**
         * Equal
         */
        // Arrange
        $alfa = $this->randomAngle();
        $beta = (string) clone $alfa;

        // Act & Assert
        $this->assertFalse(new GreaterString($alfa, $beta)->compare());
    }
}