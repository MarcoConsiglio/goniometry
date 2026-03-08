<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserOrEqualFloat;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\Feature\AngleTest;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DependsExternal;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The LesserOrEqualFloat comparison strategy")]
#[CoversClass(LesserOrEqualFloat::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class LesserOrEqualFloatTest extends TestCase
{
    #[DependsExternal(AngleTest::class, "test_cast_to_decimal")]
    #[TestDox("can compare an Angle and a sexadecimal angle measure.")]
    public function test_compare(): void
    {
        /**
         * Lesser
         */
        // Arrange
        $alfa = $this->randomAngle(max: 180 - self::SSN);
        $beta = $this->randomAngle(min: 180)->toDecimal();

        // Act & Assert
        $this->assertTrue(new LesserOrEqualFloat($alfa, $beta)->compare());

        /**
         * Equal
         */
        // Arrange
        $alfa = $this->randomAngle();
        $beta = $alfa->toDecimal();

        // Act & Assert
        $this->assertTrue(new LesserOrEqualFloat($alfa, $beta)->compare());

        /**
         * Greater
         */
        // Arrange
        $alfa = $this->randomAngle(min: 180);
        $beta = $this->randomAngle(max: 180 - self::SSN)->toDecimal();

        // Act & Assert
        $this->assertFalse(new LesserOrEqualFloat($alfa, $beta)->compare());
    }
}