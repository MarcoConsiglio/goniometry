<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterOrEqualInt;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DependsOnClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The GreaterOrEqualInt comparison strategies")]
#[CoversClass(GreaterOrEqualInt::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(FromDegrees::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(GreaterAngle::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class GreaterOrEqualIntTest extends TestCase
{
    #[DependsOnClass(EqualAngleTest::class)]
    #[DependsOnClass(GreaterAngleTest::class)]
    #[TestDox("can compare an Angle instance and a sexagesimal degrees angle measure.")]
    public function test_compare(): void
    {
        /**
         * Greater
         */
        // Arrange
        $alfa = $this->randomAngle(min: 180);
        $beta = $this->randomDegrees(max: 179);

        // Act & Assert
        $this->assertTrue(new GreaterOrEqualInt($alfa, $beta)->compare());

        /**
         * Equal
         */
        // Arrange
        $beta = $this->randomDegrees();
        $alfa = Angle::createFromValues($beta);

        // Act & Assert
        $this->assertTrue(new GreaterOrEqualInt($alfa, $beta)->compare());

        /**
         * Lesser
         */
        // Arrange
        $alfa = $this->randomAngle(max: 180 - self::SSN);
        $beta = $this->randomDegrees(min: 180);

        // Act & Assert
        $this->assertFalse(new GreaterOrEqualInt($alfa, $beta)->compare());
    }
}