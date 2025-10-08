<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException;
use MarcoConsiglio\Goniometry\Builders\FromString;
use MarcoConsiglio\Goniometry\Exceptions\NoMatchException;
use MarcoConsiglio\Goniometry\Exceptions\RegExFailureException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The FromString builder")]
#[CoversClass(FromString::class)]
#[UsesClass(Angle::class)]
#[UsesClass(RegExFailureException::class)]
#[UsesClass(NoMatchException::class)]
#[UsesClass(AngleOverflowException::class)]
class FromStringTest extends BuilderTestCase
{
    #[TestDox("can create a positive angle from a string value.")]
    public function test_can_create_positive_angle()
    {
        // Arrange
        $positive = Angle::COUNTER_CLOCKWISE;

        // Act & Assert
        $this->assertBuilderData(new FromString("180°"), [180, 0, 0, $positive]);
        $this->assertBuilderData(new FromString("0° 30'"), [0, 30, 0, $positive]);
        $this->assertBuilderData(new FromString("0° 0' 30\""), [0, 0, 30, $positive]);
    }

    #[TestDox("can create a negative angle from a string value.")]
    public function test_can_create_negative_angle()
    {
        // Arrange
        $negative = Angle::CLOCKWISE;

        // Act & Assert
        $this->assertBuilderData(new FromString("-180°"), [180, 0, 0, $negative]);
        $this->assertBuilderData(new FromString("-0° 30'"), [0, 30, 0, $negative]);
        $this->assertBuilderData(new FromString("-0° 0' 30\""), [0, 0, 30, $negative]);
    }
    
    #[TestDox("throws NoMatchException with more than 360° input.")]
    public function test_exception_if_more_than_360_degrees()
    {
        // Arrange
        $angle_string = "361° 0' 0\"";
        $max_degrees = Angle::MAX_DEGREES;

        // Assert
        $this->expectException(AngleOverflowException::class);
        $this->expectExceptionMessage("The angle {$angle_string} exceeds {$max_degrees}°.");

        // Act
        new FromString($angle_string);
    }

    #[TestDox("throws NoMatchException with more than 59' input.")]
    public function test_exception_if_more_than_59_minutes()
    {
        // Arrange
        $angle_string = "0° 60' 0\"";
        $max_minutes = Angle::MAX_MINUTES;

        // Assert
        $this->expectException(AngleOverflowException::class);
        $this->expectExceptionMessage("The angle {$angle_string} exceeds {$max_minutes}'.");

        // Act
        new FromString($angle_string);
    }

    #[TestDox("throws NoMatchException with more than 59.9\" input.")]
    public function test_exception_if_more_than_59_seconds()
    {
        // Arrange
        $angle_string = "0° 0' 60\"";
        $max_seconds = Angle::MAX_MINUTES;

        // Assert
        $this->expectException(AngleOverflowException::class);
        $this->expectExceptionMessage("The angle {$angle_string} exceeds {$max_seconds}\".");

        // Act
        new FromString($angle_string);
    }

    /**
     * Returns the FromString builder class.
     * @return string
     */
    protected function getBuilderClass(): string
    {
        return FromString::class;
    }
}