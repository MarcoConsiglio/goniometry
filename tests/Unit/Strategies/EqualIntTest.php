<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualInt;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\Feature\AngleTest;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Tests\Unit\Enums\DirectionTest;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DependsExternal;
use PHPUnit\Framework\Attributes\DependsOnClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The EqualInt comparison strategy")]
#[CoversClass(EqualInt::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDegrees::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class EqualIntTest extends TestCase
{
    #[DependsOnClass(EqualAngleTest::class)]
    #[DependsOnClass(AngleTest::class, "test_create_from_values")]
    #[DependsExternal(DirectionTest::class, "test_counter_clockwise")]
    #[DependsExternal(DirectionTest::class, "test_clockwise")]
    #[TestDox("can compare an Angle and a sexagesimal degrees angle measure.")]
    public function test_compare(): void
    {
        /**
         * Equal
         */
        // Arrange
        $beta = $this->randomDegrees();
        $alfa = Angle::createFromValues($beta);

        // Act & Assert
        $this->assertTrue(new EqualInt($alfa, $beta)->compare());

        /**
         * Not Equal
         */
        // Arrange
        $beta = $this->randomDegrees();
        $alfa = $this->randomAngle();

        // Act & Assert
        $this->assertFalse(new EqualInt($alfa, $beta)->compare());
    }
}