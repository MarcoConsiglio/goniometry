<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException;
use MarcoConsiglio\Goniometry\Builders\FromString;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Exceptions\NoMatchException;
use MarcoConsiglio\Goniometry\Exceptions\RegExFailureException;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The FromString builder")]
#[CoversClass(FromString::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleOverflowException::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(NoMatchException::class)]
#[UsesClass(RegExFailureException::class)]
#[UsesClass(Seconds::class)]
class FromStringTest extends BuilderTestCase
{
    #[TestDox("can create a positive angle from a string value.")]
    public function test_can_create_positive_angle()
    {
        $this->testAngleCreation(FromString::class);
    }

    #[TestDox("can create a negative angle from a string value.")]
    public function test_can_create_negative_angle()
    {
        $this->testAngleCreation(FromString::class, negative: true);
    }
    
    #[TestDox("throws NoMatchException with more than 360° input.")]
    public function test_exception_if_more_than_360_degrees()
    {
        // Arrange
        $angle_string = "361° 0' 0\"";

        // Assert
        $this->expectException(NoMatchException::class);
        $this->expectExceptionMessage("Can't recognize the string $angle_string.");

        // Act
        new FromString($angle_string);
    }

    #[TestDox("throws NoMatchException with more than 59' input.")]
    public function test_exception_if_more_than_59_minutes()
    {
        // Arrange
        $angle_string = "0° 60' 0\"";

        // Assert
        $this->expectException(NoMatchException::class);
        $this->expectExceptionMessage("Can't recognize the string $angle_string.");

        // Act
        new FromString($angle_string);
    }

    #[TestDox("throws NoMatchException with more than 59.9\" input.")]
    public function test_exception_if_more_than_59_seconds()
    {
        // Arrange
        $angle_string = "0° 0' 60\"";

        // Assert
        $this->expectException(NoMatchException::class);
        $this->expectExceptionMessage("Can't recognize the string $angle_string");

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