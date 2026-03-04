<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\DifferentInt;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualInt;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DependsOnClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The DifferentInt comparison strategy")]
#[CoversClass(DifferentInt::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDegrees::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(EqualInt::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class DifferentIntTest extends TestCase
{
    #[DependsOnClass(EqualIntTest::class)]
    #[TestDox("can compare an Angle instance and a sexagesimal degrees angle measure.")]
    public function test_compare(): void
    {
        /**
         * Different
         */
        // Arrange
        $beta = $this->randomDegrees(min : 1);
        $alfa = Angle::createFromValues($beta - 1);

        // Act & Assert
        $this->assertTrue(new DifferentInt($alfa, $beta)->compare());

        /**
         * Equal
         */
        // Arrange
        $beta = $this->randomDegrees();
        $alfa = Angle::createFromValues($beta);

        // Act & Assert
        $this->assertFalse(new DifferentInt($alfa, $beta)->compare());
    }
}