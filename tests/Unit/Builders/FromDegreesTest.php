<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;

#[TestDox("The FromDegrees builder")]
#[CoversClass(FromDegrees::class)]
#[UsesClass(AngleOverflowException::class)]
#[UsesClass(Angle::class)]
class FromDegreesTest extends BuilderTestCase
{
    #[TestDox("can create an angle from degrees values.")]
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
        $negative_direction = Angle::CLOCKWISE;

        // Act
        //  Null angles
        $alfa = Angle::createFromValues(0, 0, 0, $positive_direction);
        $beta = Angle::createFromValues(0, 0, 0, $negative_direction);

        // Assert
        $this->assertProperty("int", $direction, $alfa, $positive_direction);
        $this->assertProperty("int", $direction, $beta, $positive_direction);
    }

    #[TestDox("throws AngleOverflowException with more than 360°.")]
    public function test_exception_with_exceeding_degrees()
    {
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