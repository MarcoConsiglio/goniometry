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
use PHPUnit\Framework\MockObject\MockObject;

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
        $direction = "direction";
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

    #[TestDox("throws AngleOverflowException with more than 360°.")]
    public function test_exception_with_exceeding_degrees()
    {
        $this->markTestSkipped("This test is no longer necessary because it is allowed to create an instance of type Angle with values that exceed the full angle.");
        // Arrange
        $degrees_excess = Angle::MAX_DEGREES + 1;
        $positive = Angle::COUNTER_CLOCKWISE;

        // Assert
        $this->expectExceptionWithMessage(
            AngleOverflowException::class,
            "The angle inputs can't be greater than 360° or 59' or 59.9\"."
        );

        // Act

        new FromDegrees($degrees_excess, 0, 0, $positive);
    }

    #[TestDox("throws AngleOverflowException with more than 59'.")]
    public function test_exception_with_exceeding_minutes()
    {
        $this->markTestSkipped("This test is no longer necessary because it is allowed to create an instance of type Angle with values that exceed the full angle.");
        // Arrange
        $minutes_excess = Angle::MAX_MINUTES;
        $positive = Angle::COUNTER_CLOCKWISE;

        // Assert
        $this->expectExceptionWithMessage(
            AngleOverflowException::class,
            "The angle inputs can't be greater than 360° or 59' or 59.9\"."
        );

        // Act
        new FromDegrees(0, $minutes_excess, 0, $positive);
    }

    #[TestDox("throws AngleOverflowException with more than 59.9\".")]
    public function test_exception_with_exceeding_seconds()
    {
        $this->markTestSkipped("This test is no longer necessary because it is allowed to create an instance of type Angle with values that exceed the full angle.");
        // Arrange
        $seconds_excess = Angle::MAX_SECONDS;
        $positive = Angle::COUNTER_CLOCKWISE;

        // Assert
        $this->expectExceptionWithMessage(
            AngleOverflowException::class,
            "The angle inputs can't be greater than 360° or 59' or 59.9\"."
        );

        // Act
        new FromDegrees(0, 0, $seconds_excess, $positive);
    }

    #[TestDox("will always correct a wrong direction input.")]
    public function test_wrong_direction_value()
    {
        $this->markTestSkipped("This test is no longer necessary because the Angle type instance is created with absolute values and the direction of the angle, which determines its sign.");
        // Arrange
        $wrong_negative = -2;
        $wrong_positive = 2;
        $direction = "direction";
        $negative = Angle::CLOCKWISE;
        $positive = Angle::COUNTER_CLOCKWISE;

        // Act
        $alfa = Angle::createFromValues(180, 30, 15, $wrong_negative);
        $beta = Angle::createFromValues(180, 30, 15, $wrong_positive);
        $gamma = Angle::createFromValues(-180, -30, -15, $wrong_negative);
        $delta = Angle::createFromValues(-180, -30, -15, $wrong_positive);

        // Assert
        $this->assertProperty("int", $direction, /* of */ $alfa, /* must be */ $negative);
        $this->assertProperty("int", $direction, /* of */ $beta, /* must be */ $positive);
        $this->assertProperty("int", $direction, /* of */ $gamma, /* must be */ $negative);
        $this->assertProperty("int", $direction, /* of */ $delta, /* must be */ $positive);
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