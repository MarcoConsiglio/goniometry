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
        $this->testAngleCreation(FromDegrees::class, false);
        $this->testAngleCreation(FromDegrees::class, true);
    }

    #[TestDox("throws AngleOverflowException with more than 360° input.")]
    public function test_exception_if_more_than_360_degrees()
    {
        // Assert
        $this->expectException(AngleOverflowException::class);
        $this->expectExceptionMessage("The angle degrees can't be greater than 360°.");
        
        // Arrange & Act
        new FromDegrees(361, 0, 0);
    }

    #[TestDox("throws AngleOverflowException with more than 59'.")]
    public function test_exception_if_more_than_59_minutes()
    {
        // Assert
        $this->expectException(AngleOverflowException::class);
        $this->expectExceptionMessage("The angle minutes can't be greater than 59'.");

        // Arrange & Act
        new FromDegrees(0, 60, 0);
    }

    #[TestDox("throws AngleOverflowException with 59.9\".")]
    public function test_exception_if_equal_or_more_than_60_seconds()
    {
        // Assert
        $this->expectException(AngleOverflowException::class);
        $this->expectExceptionMessage("The angle seconds can't be greater than 59.9\".");
        
        // Arrange & Act
        new FromDegrees(0, 0, 60);
    }
    
    #[TestDox("set the null angle with positive/counterclockwise direction.")]
    public function test_null_angle_is_positive()
    {
        // Arrange & Act
        $null_angle = Angle::createFromValues(0);

        // Assert
        $this->assertEquals(Angle::COUNTER_CLOCKWISE, $null_angle->direction,
            "A null angle should be counterclockwise, but found the opposite."
        );
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