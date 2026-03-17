<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\FromString;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Exceptions\NoMatchException;
use MarcoConsiglio\Goniometry\Exceptions\RegExFailureException;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The FromString builder")]
#[CoversClass(FromString::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromSexagesimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(NoMatchException::class)]
#[UsesClass(RegExFailureException::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class FromStringTest extends TestCase
{
    #[TestDox("can create a positive angle from a string value.")]
    public function test_can_create_positive_angle()
    {
        // Arrange
        $degrees = new Degrees($this->randomDegrees());
        $minutes = new Minutes($this->randomMinutes());
        $seconds = new Seconds($this->randomSeconds());
        $direction = Direction::COUNTER_CLOCKWISE;
        $sign = '';
        
        // Act
        $builder = new FromString("{$sign}{$degrees} {$minutes} {$seconds}");
        [$sexagesimal] = $builder->fetchData();
        
        //Assert
        $this->assertEquals($degrees->value(), $sexagesimal->degrees->value());
        $this->assertEquals($minutes->value(), $sexagesimal->minutes->value());
        $this->assertEquals($seconds->value(), $sexagesimal->seconds->value());
        $this->assertEquals($direction, $sexagesimal->direction);
    }

    #[TestDox("can create a negative angle from a string value.")]
    public function test_can_create_negative_angle()
    {
        // Arrange
        $degrees = new Degrees($this->randomDegrees());
        $minutes = new Minutes($this->randomMinutes());
        $seconds = new Seconds($this->randomSeconds());
        $direction = Direction::CLOCKWISE;
        $sign = '-';
        
        // Act
        $builder = new FromString("{$sign}{$degrees} {$minutes} {$seconds}");
        [$sexagesimal] = $builder->fetchData();
        
        //Assert
        $this->assertEquals($degrees->value(), $sexagesimal->degrees->value());
        $this->assertEquals($minutes->value(), $sexagesimal->minutes->value());
        $this->assertEquals($seconds->value(), $sexagesimal->seconds->value());
        $this->assertEquals($direction, $sexagesimal->direction);
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
}