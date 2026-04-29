<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\FromString;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Exceptions\NoMatchException;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\Degrees as DegreesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Minutes as MinutesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Seconds as SecondsGenerator;
use MarcoConsiglio\Goniometry\Random\SecondsRange;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Minutes as MinutesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Seconds as SecondsValidator;
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
#[UsesClass(Degrees::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(DegreesGenerator::class)]
#[UsesClass(DegreesValidator::class)]
#[UsesClass(FromSexagesimal::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(MinutesGenerator::class)]
#[UsesClass(MinutesValidator::class)]
#[UsesClass(NoMatchException::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SecondsGenerator::class)]
#[UsesClass(SecondsRange::class)]
#[UsesClass(SecondsValidator::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class FromStringTest extends TestCase
{
    #[TestDox("can create a positive angle from a string value.")]
    public function test_can_create_positive_angle(): void
    {
        // Arrange
        $degrees = $this->randomDegrees();
        $minutes = $this->randomMinutes();
        $seconds = $this->randomSeconds(precision: 1);
        $direction = Direction::COUNTER_CLOCKWISE;
        $sign = '';
        
        // Act
        $builder = new FromString("{$sign}{$degrees} {$minutes} {$seconds}");
        [$sexagesimal] = $builder->fetchData();
        
        //Assert
        $this->assertDegrees($degrees, $sexagesimal->degrees);
        $this->assertMinutes($minutes, $sexagesimal->minutes);
        $this->assertSeconds($seconds, $sexagesimal->seconds);
        $this->assertDirection($direction, $sexagesimal->direction);
    }

    #[TestDox("can create a negative angle from a string value.")]
    public function test_can_create_negative_angle(): void
    {
        // Arrange
        $degrees = $this->randomDegrees();
        $minutes = $this->randomMinutes();
        $seconds = $this->randomSeconds(precision: 1);
        $direction = Direction::CLOCKWISE;
        $sign = '-';
        
        // Act
        $builder = new FromString("{$sign}{$degrees} {$minutes} {$seconds}");
        [$sexagesimal] = $builder->fetchData();
        
        //Assert
        $this->assertDegrees($degrees, $sexagesimal->degrees);
        $this->assertMinutes($minutes, $sexagesimal->minutes);
        $this->assertSeconds($seconds, $sexagesimal->seconds);
        $this->assertDirection($direction, $sexagesimal->direction);
    }
    
    #[TestDox("throws NoMatchException with more than 360° input.")]
    public function test_exception_if_more_than_360_degrees(): void
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
    public function test_exception_if_more_than_59_minutes(): void
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
    public function test_exception_if_more_than_59_seconds(): void
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