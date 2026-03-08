<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The FromDegrees builder")]
#[CoversClass(FromDegrees::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleOverflowException::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class FromDegreesTest extends BuilderTestCase
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
        $gamma =    Angle::createFromValues(0, 0, 1, $positive_direction);
        $delta =    Angle::createFromValues(0, 1, 0, $positive_direction);
        $epsilon =  Angle::createFromValues(0, 1, 1, $positive_direction);
        $zeta =     Angle::createFromValues(1, 0, 0, $positive_direction);
        $eta =      Angle::createFromValues(1, 0, 1, $positive_direction);
        $theta =    Angle::createFromValues(1, 1, 0, $positive_direction);
        $iota =     Angle::createFromValues(1, 1, 1, $positive_direction);
        $kappa =    Angle::createFromValues(0, 0, 1, $negative_direction);
        $lambda =   Angle::createFromValues(0, 1, 0, $negative_direction);
        $mi =       Angle::createFromValues(0, 1, 1, $negative_direction);
        $ni =       Angle::createFromValues(1, 0, 0, $negative_direction);
        $xi =       Angle::createFromValues(1, 0, 1, $negative_direction);
        $omicron =  Angle::createFromValues(1, 1, 0, $negative_direction);
        $rho =      Angle::createFromValues(1, 1, 1, $negative_direction);

        // Assert
        //  Null angles
        $this->assertEquals($positive_direction, $alfa->direction,     $this->propertyFail("direction"));
        $this->assertEquals($positive_direction, $beta->direction,     $this->propertyFail("direction"));
        //  Non-null angles
        $this->assertEquals($positive_direction, $gamma->direction,    $this->propertyFail("direction"));
        $this->assertEquals($positive_direction, $delta->direction,    $this->propertyFail("direction"));
        $this->assertEquals($positive_direction, $epsilon->direction,  $this->propertyFail("direction"));
        $this->assertEquals($positive_direction, $zeta->direction,     $this->propertyFail("direction"));
        $this->assertEquals($positive_direction, $eta->direction,      $this->propertyFail("direction"));
        $this->assertEquals($positive_direction, $theta->direction,    $this->propertyFail("direction"));
        $this->assertEquals($positive_direction, $iota->direction,     $this->propertyFail("direction"));
        $this->assertEquals($negative_direction, $kappa->direction,    $this->propertyFail("direction"));
        $this->assertEquals($negative_direction, $lambda->direction,   $this->propertyFail("direction"));
        $this->assertEquals($negative_direction, $mi->direction,       $this->propertyFail("direction"));
        $this->assertEquals($negative_direction, $ni->direction,       $this->propertyFail("direction"));
        $this->assertEquals($negative_direction, $xi->direction,       $this->propertyFail("direction"));
        $this->assertEquals($negative_direction, $omicron->direction,  $this->propertyFail("direction"));
        $this->assertEquals($negative_direction, $rho->direction,      $this->propertyFail("direction"));
    }

    /**
     * Returns the FromDegrees builder class.
     * @return string
     */
    protected function getBuilderClass(): string
    {
        return FromDegrees::class;
    }
}