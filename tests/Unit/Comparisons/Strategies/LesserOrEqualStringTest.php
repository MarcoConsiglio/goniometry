<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserOrEqualString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserString;
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

#[TestDox("The LesserOrEqualString comparison strategy")]
#[CoversClass(LesserOrEqualString::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(FromString::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(EqualString::class)]
#[UsesClass(GreaterAngle::class)]
#[UsesClass(LesserAngle::class)]
#[UsesClass(LesserString::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class LesserOrEqualStringTest extends TestCase
{
    #[DependsExternal(AngleTest::class, "test_create_from_string")]
    #[DependsOnClass(EqualStringTest::class)]
    #[DependsOnClass(LesserStringTest::class)]
    #[TestDox("can compare an Angle and a sexagesimal string angle measure.")]
    public function test_compare(): void
    {
        /**
         * Lesser
         */
        // Arrange
        $alfa = $this->randomAngle(max: 180 - self::SSN);
        $beta = (string) $this->randomAngle(min: 180);

        // Act & Assert
        $this->assertTrue(new LesserOrEqualString($alfa, $beta)->compare());

        /**
         * Equal
         */
        // Arrange
        $alfa = $this->randomAngle();
        $beta = (string) $alfa;

        // Act & Assert
        $this->assertTrue(new LesserOrEqualString($alfa, $beta)->compare());

        /**
         * Greater
         */
        // Arrange
        $alfa = $this->randomAngle(min: 180);
        $beta = (string) $this->randomAngle(max: 180 - self::SSN);

        // Act & Assert
        $this->assertFalse(new LesserOrEqualString($alfa, $beta)->compare());
    }
}