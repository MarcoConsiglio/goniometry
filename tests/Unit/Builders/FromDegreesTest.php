<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The FromDegrees builder")]
#[CoversClass(FromDegrees::class)]
#[UsesClass(AngleOverflowException::class)]
#[UsesClass(Angle::class)]
class FromDegreesTest extends BuilderTestCase
{
    #[TestDox("can create an angle from a degrees values.")]
    public function test_can_create_an_angle()
    {
        $this->testAngleCreation(FromDegrees::class, false);    // Positive angle.
        $this->testAngleCreation(FromDegrees::class, true);     // Negative angle.
    }

    #[TestDox("will always create a null angle with positive direction.")]
    public function test_can_create_a_null_angle()
    {
        // Arrange
        $direction = "direction";
        $positive_direction = Angle::COUNTER_CLOCKWISE;

        // Act
        $alfa = Angle::createFromValues(0, 0, 0);
        $beta = Angle::createFromValues(0, 0, 0, Angle::CLOCKWISE);

        // Assert
        $this->assertProperty("int", $direction, $alfa, $positive_direction);
        $this->assertProperty("int", $direction, $beta, $positive_direction);
    }

    #[TestDox("throws AngleOverflowException with more than 360°, 59' or 59.9\" input.")]
    public function test_exception_if_more_than_360_degrees()
    {
        // Arrange
        $degrees_excess = 361;
        $minutes_excess = 60;
        $seconds_excess = 60;
        $positive = Angle::COUNTER_CLOCKWISE;
        $negative = Angle::CLOCKWISE;

        // Assert
        $this->expectException(AngleOverflowException::class);
        $this->expectExceptionMessage("The angle inputs can't be greater than 360° or 59' or 59.9\".");
        
        // Act
        new FromDegrees(0, 0, $seconds_excess, $positive);
        new FromDegrees(0, $minutes_excess, 0, $positive);
        new FromDegrees(0, $minutes_excess, $seconds_excess);
        new FromDegrees($degrees_excess, 0, 0, $positive);
        new FromDegrees($degrees_excess, 0, $seconds_excess, $positive);
        new FromDegrees($degrees_excess, $minutes_excess, 0, $positive);
        new FromDegrees($degrees_excess, $minutes_excess, $seconds_excess, $positive);

        new FromDegrees(0, 0, $seconds_excess, $negative);
        new FromDegrees(0, $minutes_excess, 0, $negative);
        new FromDegrees(0, $minutes_excess, $seconds_excess, $negative);
        new FromDegrees($degrees_excess, 0, 0, $negative);
        new FromDegrees($degrees_excess, 0, $seconds_excess, $negative);
        new FromDegrees($degrees_excess, $minutes_excess, 0, $negative);
        new FromDegrees($degrees_excess, $minutes_excess, $seconds_excess, $negative);
    }

    #[TestDox("will always correct a wrong direction input.")]
    public function test_wrong_direction_value()
    {
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