<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Casting\Radian;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Casting\Radian\Cast;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The Radian\Cast class")]
#[CoversClass(Cast::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(Direction::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
class CastTest extends TestCase
{
    #[TestDox("can cast an Angle to radian with a specified precision.")]
    public function test_cast_with_precision(): void
    {
        // Arrange
        $precision = $this->randomPrecision();
        $angle = $this->randomAngle();
        $sexadecimal = $angle->toSexadecimalDegrees();
        $radian = $sexadecimal->value->toRadian()->toFloat($precision);

        // Act
        $actual_radian = $angle->toRadian($precision);

        // Assert
        $this->assertSame($radian, $actual_radian,
            "{$sexadecimal} = {$radian} but expected radian {$radian} ≠ {$actual_radian} actual radian using precision $precision."
        );
    }

    public function test_cast_without_precision(): void
    {
        // Arrange
        $angle = $this->randomAngle();
        $sexadecimal = $angle->toSexadecimalDegrees();
        $radian = $sexadecimal->value->toRadian()->toFloat();

        // Act
        $actual_radian = $angle->toRadian();

        // Assert
        $this->assertSame($radian, $actual_radian,
            "{$sexadecimal} = {$radian} but expected radian {$radian} ≠ {$actual_radian} actual radian."
        );
    }
}