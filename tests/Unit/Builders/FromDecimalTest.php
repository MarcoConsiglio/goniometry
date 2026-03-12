<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
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
#[UsesClass(SexadecimalDegrees::class)]
class FromDecimalTest extends BuilderTestCase
{
    #[TestDox("can create a counter-clockwise Angle from a positive sexadecimal value.")]
    public function test_create_angle_from_positive_decimal_degrees()
    {
        // Arrange
        $decimal_input = $this->positiveRandomSexadecimal();
        [$degrees, $minutes, $seconds, $direction] = $this->toSexagesimal($decimal_input);

        // Act
        $angle = Angle::createFromDecimal($decimal_input);

        // Assert
        $failure_message = "{$decimal_input}° should be equal to {$degrees}{$minutes}{$seconds}";
        $this->assertTrue($angle->degrees->eq($degrees), $failure_message);
        $this->assertTrue($angle->minutes->eq($minutes), $failure_message);
        $this->assertTrue($angle->seconds->eq($seconds), $failure_message);
        $this->assertEquals($direction, $angle->direction);
    }

    #[TestDox("can create a clockwise Angle from a negative sexadecimal value.")]
    public function test_create_angle_from_negative_decimal_degrees()
    {
        // Arrange
        $decimal_input = $this->negativeRandomSexadecimal();
        [$degrees, $minutes, $seconds, $direction] = $this->toSexagesimal($decimal_input);

        // Act
        $angle = Angle::createFromDecimal($decimal_input);

        // Assert
        $failure_message = "{$decimal_input}° should be equal to -{$degrees}{$minutes}{$seconds}";
        $this->assertTrue($angle->degrees->eq($degrees), $failure_message);
        $this->assertTrue($angle->minutes->eq($minutes), $failure_message);
        $this->assertTrue($angle->seconds->eq($seconds), $failure_message);
        $this->assertEquals($direction, $angle->direction);
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