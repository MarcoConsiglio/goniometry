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
use MarcoConsiglio\Goniometry\Tests\TestCase;
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
class FromDecimalTest extends TestCase
{
    #[TestDox("can create a counter-clockwise Angle from a positive sexadecimal value.")]
    public function test_create_angle_from_positive_decimal_degrees()
    {
        /**
         * Float type input
         */
        // Arrange
        $float_input = $this->positiveRandomSexadecimal();
        [$degrees, $minutes, $seconds, $direction] = $this->toSexagesimal($float_input);

        // Act
        $result = new FromDecimal($float_input)->fetchData();

        // Assert
        $this->assertEquals($degrees->value(), $result[0]->value());
        $this->assertEquals($minutes->value(), $result[1]->value());
        $this->assertEquals($seconds->value(), $result[2]->value());
        $this->assertEquals($direction->value, $result[3]->value);

        /**
         * SexagesimalDegrees type input
         */
        // Arrange
        $sexadecimal = new SexadecimalDegrees($this->positiveRandomSexadecimal());
        [$degrees, $minutes, $seconds, $direction] = $this->toSexagesimal($sexadecimal->value());

        // Act
        $result = new FromDecimal($sexadecimal)->fetchData();

        // Assert
        $this->assertEquals($degrees->value(), $result[0]->value());
        $this->assertEquals($minutes->value(), $result[1]->value());
        $this->assertEquals($seconds->value(), $result[2]->value());
        $this->assertEquals($direction->value, $result[3]->value);
    }

    #[TestDox("can create a clockwise Angle from a negative sexadecimal value.")]
    public function test_create_angle_from_negative_decimal_degrees()
    {
        /**
         * Float type input
         */
        // Arrange
        $float_input = $this->negativeRandomSexadecimal();
        [$degrees, $minutes, $seconds, $direction] = $this->toSexagesimal($float_input);

        // Act
        $result = new FromDecimal($float_input)->fetchData();

        // Assert
        $this->assertEquals($degrees->value(), $result[0]->value());
        $this->assertEquals($minutes->value(), $result[1]->value());
        $this->assertEquals($seconds->value(), $result[2]->value());
        $this->assertEquals($direction->value, $result[3]->value);

        /**
         * SexadecimalDegrees type input
         */
        // Arrange
        $sexadecimal = new SexadecimalDegrees($this->negativeRandomSexadecimal());
        [$degrees, $minutes, $seconds, $direction] = $this->toSexagesimal($sexadecimal->value());

        // Act
        $result = new FromDecimal($sexadecimal)->fetchData();

        // Assert
        $this->assertEquals($degrees->value(), $result[0]->value());
        $this->assertEquals($minutes->value(), $result[1]->value());
        $this->assertEquals($seconds->value(), $result[2]->value());
        $this->assertEquals($direction->value, $result[3]->value);
    }
}