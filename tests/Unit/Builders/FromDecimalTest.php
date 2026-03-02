<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The FromDecimal builder")]
#[CoversClass(FromDecimal::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleOverflowException::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class FromDecimalTest extends BuilderTestCase
{
    #[TestDox("can create an Angle from a sexadecimal value.")]
    public function test_can_create_an_angle_from_decimal_degrees()
    {
        // Arrange
        $decimal_input = $this->randomFloat(max: Angle::MAX_DEGREES * 3);
        [$degrees, $minutes, $seconds, $direction] = $this->toSexagesimal($decimal_input);
        $sign = $direction == Direction::CLOCKWISE ? '-' : '';

        // Act
        $angle = Angle::createFromDecimal($decimal_input);

        // Assert
        $failure_message = "{$decimal_input}° should be equal to {$sign}{$degrees}°{$minutes}'{$seconds}\"";
        $this->assertTrue($angle->degrees->value->isEqual($degrees), $failure_message);
        $this->assertTrue($angle->minutes->value->isEqual($minutes), $failure_message);
        $this->assertTrue($angle->seconds->value->isEqual($seconds), $failure_message);
        $this->assertEquals($direction, $angle->direction);
    }

    #[TestDox("throws AngleOverflowException with more than +/-360° input.")]
    public function test_exception_if_greater_than_360_degrees()
    {   
        $this->markTestSkipped("This test is no longer necessary because it is allowed to create an instance of type Angle with values ​​that exceed the full angle."); 
        // Assert
        $this->expectException(AngleOverflowException::class);
        $this->expectExceptionMessage("The angle can't be greather than 360°.");

        // Arrange & Act
        new FromDecimal(360.00001);
    }

    /**
     * Returns the FromDecimal builder class.
     * @return string
     */
    protected function getBuilderClass(): string
    {
        return FromDecimal::class;
    }
}