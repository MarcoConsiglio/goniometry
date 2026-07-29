<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders\Angle;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\Angle\FromRadian;
use MarcoConsiglio\Goniometry\Casting\Radian\Round;
use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\RadianAngle;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeRadian as NegativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveRadian as PositiveRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Radian as RadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeRadian as RelativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeRadian as RelativeRadianValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngle;

use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(FromRadian::class)]
#[UsesClass(Angle::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(PositiveRadianGenerator::class)]
#[UsesClass(RadianAngle::class)]
#[UsesClass(RadianGenerator::class)]
#[UsesClass(RadianRange::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(RelativeRadianGenerator::class)]
#[UsesClass(RelativeRadianValidator::class)]
#[UsesClass(Round::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(Sexagesimal::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
#[UsesClass(NegativeRadianGenerator::class)]
class FromRadianTest extends TestCase
{
    public function test_can_create_an_angle_from_float_value(): void
    {
        // Arrange
        $radian = $this->randomRadian()->value(5);
        $builder = new FromRadian($radian);

        // Act
        $result = $builder->fetchData();

        // Assert
        $this->assertEquals(
            $radian,
            $result[2]->value(5)
        );
        $this->assertInstanceOf(SexagesimalDegrees::class, $result[0]);
        $this->assertInstanceOf(SexadecimalAngle::class, $result[1]);
    }

    public function test_can_create_an_angle_from_radian_type(): void
    {
        // Arrange
        $radian = $this->randomRadian(precision: 1);
        $builder = new FromRadian($radian);

        // Act
        $result = $builder->fetchData();

        // Assert
        $this->assertEquals(
            $radian->value(),
            $result[2]->value()
        );
        $this->assertInstanceOf(SexagesimalDegrees::class, $result[0]);
        $this->assertInstanceOf(SexadecimalAngle::class, $result[1]);
    }
}