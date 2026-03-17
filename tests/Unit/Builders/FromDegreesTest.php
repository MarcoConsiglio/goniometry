<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromSexagesimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The FromSexagesimal builder")]
#[CoversClass(FromSexagesimal::class)]
#[UsesClass(Angle::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class FromDegreesTest extends TestCase
{
    #[TestDox("can create an angle from degrees values.")]
    public function test_can_create_an_angle()
    {
        // Arrange
        [$degrees, $minutes, $seconds, $direction] = 
            $this->randomSexagesimal();

        // Act
        $angle = Angle::createFromValues($degrees, $minutes, $seconds, $direction);

        // Assert
        $this->assertInstanceOf(Angle::class, $angle,
            $this->methodMustReturn(Angle::class, "createFromValues", Angle::class)
        );
    }

    #[TestDox("will always create a null angle with positive direction.")]
    public function test_can_create_a_null_angle()
    {
        // Arrange
        $positive_direction = Direction::COUNTER_CLOCKWISE;
        $negative_direction = Direction::CLOCKWISE;

        // Act
        //  Null angles
        $alfa = Angle::createFromValues(0, 0, 0, $positive_direction);
        $beta = Angle::createFromValues(0, 0, 0, $negative_direction);
        //  Non-null angles
        $gamma =    Angle::createFromValues(1, 0, 0, $negative_direction);
        $epsilon =  Angle::createFromValues(0, 1, 0, $negative_direction);
        $iota =     Angle::createFromValues(0, 0, 1, $negative_direction);
        // Assert
        //  Null angles
        $this->assertEquals($positive_direction, $alfa->direction);
        $this->assertEquals($positive_direction, $beta->direction);
        //  Non-null angles
        $this->assertEquals($negative_direction, $gamma->direction);
        $this->assertEquals($negative_direction, $epsilon->direction);
        $this->assertEquals($negative_direction, $iota->direction);
    }
}