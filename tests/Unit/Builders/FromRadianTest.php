<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\FromRadian;
use MarcoConsiglio\Goniometry\Casting\Radian\Round;
use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The FromRadian builder")]
#[CoversClass(FromRadian::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Round::class)]
#[UsesClass(Sexagesimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Radian::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class FromRadianTest extends TestCase
{
    #[TestDox("can create an angle from a radian float value.")]
    public function test_can_create_an_angle_from_float_value()
    {
        // Arrange
        $radian_value = $this->randomRadian();

        // Act
        $angle = Angle::createFromRadian($radian_value);

        // Assert
        $this->assertEquals(
            $this->safeRound($radian_value),
            $angle->toRadian(self::PRECISION)
        );
    }

    #[TestDox("can create an angle from a Radian type value.")]
    public function test_can_create_an_angle_from_radian_type()
    {
        // Arrange
        $radian_value = new Radian($this->randomRadian());

        // Act
        $angle = Angle::createFromRadian($radian_value);

        // Assert
        $this->assertEquals(
            $radian_value->value(self::PRECISION),
            $angle->toRadian(self::PRECISION)
        );
    }
}