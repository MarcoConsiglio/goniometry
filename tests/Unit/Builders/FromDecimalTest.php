<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The FromDecimal builder")]
#[CoversClass(FromDecimal::class)]
#[UsesClass(Angle::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
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
        [$sexagesimal, $sexadecimal] = new FromDecimal($float_input)->fetchData();

        // Assert
        $this->assertEquals($degrees->value(), $sexagesimal->degrees->value());
        $this->assertEquals($minutes->value(), $sexagesimal->minutes->value());
        $this->assertEquals($seconds->value(), $sexagesimal->seconds->value());
        $this->assertEquals($direction, $sexagesimal->direction);
        $this->assertEquals(
            $this->safeRound($float_input),
            $sexadecimal->value(self::PRECISION)
        );

        /**
         * SexagesimalDegrees type input
         */
        // Arrange
        $expected_sexadecimal = new SexadecimalDegrees($this->positiveRandomSexadecimal());
        [$degrees, $minutes, $seconds, $direction] = $this->toSexagesimal($expected_sexadecimal->value());

        // Act
        [$sexagesimal, $sexadecimal] = new FromDecimal($expected_sexadecimal)->fetchData();

        // Assert
        $this->assertEquals($degrees->value(), $sexagesimal->degrees->value());
        $this->assertEquals($minutes->value(), $sexagesimal->minutes->value());
        $this->assertEquals($seconds->value(self::PRECISION), $sexagesimal->seconds->value(self::PRECISION));
        $this->assertEquals($direction, $sexagesimal->direction);
        $this->assertEquals(
            $expected_sexadecimal->value(self::PRECISION),
            $sexadecimal->value(self::PRECISION)
        );
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
        [$sexagesimal, $sexadecimal] = new FromDecimal($float_input)->fetchData();

        // Assert
        $this->assertEquals($degrees->value(), $sexagesimal->degrees->value());
        $this->assertEquals($minutes->value(), $sexagesimal->minutes->value());
        $this->assertEquals($seconds->value(), $sexagesimal->seconds->value());
        $this->assertEquals($direction, $sexagesimal->direction);
        $this->assertEquals(
            $this->safeRound($float_input),
            $sexadecimal->value(self::PRECISION)
        );

        /**
         * SexadecimalDegrees type input
         */
        // Arrange
        $expected_sexadecimal = new SexadecimalDegrees($this->negativeRandomSexadecimal());
        [$degrees, $minutes, $seconds, $direction] = $this->toSexagesimal($expected_sexadecimal->value());

        // Act
        [$sexagesimal, $sexadecimal] = new FromDecimal($expected_sexadecimal)->fetchData();

        // Assert
        $this->assertEquals($degrees->value(), $sexagesimal->degrees->value());
        $this->assertEquals($minutes->value(), $sexagesimal->minutes->value());
        $this->assertEquals($seconds->value(self::PRECISION), $sexagesimal->seconds->value(self::PRECISION));
        $this->assertEquals($direction, $sexagesimal->direction);
        $this->assertEquals(
            $expected_sexadecimal->value(self::PRECISION),
            $sexadecimal->value(self::PRECISION)
        );
    }
}