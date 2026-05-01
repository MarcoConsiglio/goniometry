<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders\Angle;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\Angle\FromRadian;
use MarcoConsiglio\Goniometry\Casting\Radian\Round;
use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeRadian as NegativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveRadian as PositiveRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Radian as RadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeRadian as RelativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeRadian as RelativeRadianValidator;
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
#[UsesClass(Degrees::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(PositiveRadianGenerator::class)]
#[UsesClass(Radian::class)]
#[UsesClass(RadianGenerator::class)]
#[UsesClass(RadianRange::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(RelativeRadianGenerator::class)]
#[UsesClass(RelativeRadianValidator::class)]
#[UsesClass(Round::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(Sexagesimal::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
#[UsesClass(NegativeRadianGenerator::class)]
class FromRadianTest extends TestCase
{
    #[TestDox("can create an angle from a radian float value.")]
    public function test_can_create_an_angle_from_float_value(): void
    {
        // Arrange
        $radian = $this->randomRadian(precision: 1);

        // Act
        $angle = Angle::createFromRadian($radian->value());

        // Assert
        $this->assertEquals(
            $radian->value(),
            $angle->toRadian()
        );
    }

    #[TestDox("can create an angle from a Radian type value.")]
    public function test_can_create_an_angle_from_radian_type(): void
    {
        // Arrange
        $radian_value = $this->randomRadian(precision: 1);

        // Act
        $angle = Angle::createFromRadian($radian_value);

        // Assert
        $this->assertEquals(
            $radian_value->value(),
            $angle->toRadian()
        );
    }
}