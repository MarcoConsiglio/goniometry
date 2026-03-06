<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LessAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LessInt;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DependsOnClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The LessInt comparison strategy")]
#[CoversClass(LessInt::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(FromDegrees::class)]
#[UsesClass(GreaterAngle::class)]
#[UsesClass(LessAngle::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class LessIntTest extends TestCase
{
    #[DependsOnClass(LessAngleTest::class)]
    #[TestDox("can compare an Angle instance and a sexagesimal degrees angle measure.")]
    public function test_compare(): void
    {
        /**
         * Lesser
         */
        // Arrange
        $alfa = $this->randomAngle(max: 180 - self::SSN);
        $beta = $this->randomDegrees(min: 180);

        // Act & Assert
        $this->assertTrue(new LessInt($alfa, $beta)->compare());

        /**
         * Equal
         */
        // Arrange
        $beta = $this->randomDegrees();
        $alfa = Angle::createFromValues($beta);

        // Act & Assert
        $this->assertFalse(new LessInt($alfa, $beta)->compare());

        /**
         * Greater
         */
        // Arrange
        $alfa = $this->randomAngle(min: 180);
        $beta = $this->randomDegrees(max: 179);

        // Act & Assert
        $this->assertFalse(new LessInt($alfa, $beta)->compare());
    }
}