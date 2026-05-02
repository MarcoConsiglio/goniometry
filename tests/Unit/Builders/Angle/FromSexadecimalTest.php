<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders\Angle;

use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The FromSexadecimal builder")]
#[CoversClass(FromSexadecimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexadecimalValidator::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class FromSexadecimalTest extends TestCase
{
    #[TestDox("can create a counter-clockwise Angle from a positive sexadecimal value.")]
    public function test_create_angle_from_positive_decimal_degrees(): void
    {
        /**
         * Float type input
         */
        // Arrange
        $float_input = $this->positiveRandomSexadecimal(precision: 1);
        [$degrees, $minutes, $seconds, $direction] = $this->toSexagesimal($float_input);

        // Act
        [$sexagesimal, $sexadecimal] = new FromSexadecimal($float_input)->fetchData();

        // Assert
        $this->assertInstanceOf(SexagesimalDegrees::class, $sexagesimal);
        $this->assertInstanceOf(SexadecimalDegrees::class, $sexadecimal);
        $this->assertDegrees($degrees, $sexagesimal->degrees);
        $this->assertMinutes($minutes, $sexagesimal->minutes);
        $this->assertSeconds($seconds, $sexagesimal->seconds);
        $this->assertDirection($direction, $sexagesimal->direction);
        $this->assertEquals($float_input, $sexadecimal->value(1));

        /**
         * SexagesimalDegrees type input
         */
        // Arrange
        $expected_sexadecimal = new SexadecimalDegrees(
            $this->positiveRandomSexadecimal(precision: 1)
        );
        [$degrees, $minutes, $seconds, $direction] = $this->toSexagesimal(
            $expected_sexadecimal->value()
        );

        // Act
        [$sexagesimal, $sexadecimal] = new FromSexadecimal($expected_sexadecimal)->fetchData();

        // Assert
        $this->assertInstanceOf(SexagesimalDegrees::class, $sexagesimal);
        $this->assertInstanceOf(SexadecimalDegrees::class, $sexadecimal);
        $this->assertDegrees($degrees, $sexagesimal->degrees);
        $this->assertMinutes($minutes, $sexagesimal->minutes);
        $this->assertSeconds($seconds, $sexagesimal->seconds);
        $this->assertDirection($direction, $sexagesimal->direction);
        $this->assertEquals(
            $expected_sexadecimal->value(1),
            $sexadecimal->value(1)
        );
    }

    #[TestDox("can create a clockwise Angle from a negative sexadecimal value.")]
    public function test_create_angle_from_negative_decimal_degrees(): void
    {
        /**
         * Float type input
         */
        // Arrange
        $float_input = $this->negativeRandomSexadecimal(precision: 1);
        [$degrees, $minutes, $seconds, $direction] = $this->toSexagesimal($float_input);

        // Act
        [$sexagesimal, $sexadecimal] = new FromSexadecimal($float_input)->fetchData();

        // Assert
        $this->assertInstanceOf(SexagesimalDegrees::class, $sexagesimal);
        $this->assertInstanceOf(SexadecimalDegrees::class, $sexadecimal);
        $this->assertDegrees($degrees, $sexagesimal->degrees);
        $this->assertMinutes($minutes, $sexagesimal->minutes);
        $this->assertSeconds($seconds, $sexagesimal->seconds);
        $this->assertDirection($direction, $sexagesimal->direction);
        $this->assertEquals(
            $float_input,
            $sexadecimal->value(1)
        );

        /**
         * SexadecimalDegrees type input
         */
        // Arrange
        $expected_sexadecimal = new SexadecimalDegrees(
            $this->negativeRandomSexadecimal(precision: 1)
        );
        [$degrees, $minutes, $seconds, $direction] = $this->toSexagesimal(
            $expected_sexadecimal->value()
        );

        // Act
        [$sexagesimal, $sexadecimal] = new FromSexadecimal($expected_sexadecimal)->fetchData();

        // Assert
        $this->assertInstanceOf(SexagesimalDegrees::class, $sexagesimal);
        $this->assertInstanceOf(SexadecimalDegrees::class, $sexadecimal);
        $this->assertDegrees($degrees, $sexagesimal->degrees);
        $this->assertMinutes($minutes, $sexagesimal->minutes);
        $this->assertSeconds($seconds, $sexagesimal->seconds);
        $this->assertDirection($direction, $sexagesimal->direction);
        $this->assertEquals(
            $expected_sexadecimal->value(1),
            $sexadecimal->value(1)
        );
    }
}