<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders\AngularDistance;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal as AngleFromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromString;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Exceptions\NoMatchException;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Random\Generator\Angle as AngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Degrees as DegreesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\FloatGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Minutes as MinutesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngularDistance as RelativeAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Seconds as SecondsGenerator;
use MarcoConsiglio\Goniometry\Random\SecondsRange;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Minutes as MinutesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeAngularDistance as RelativeAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Seconds as SecondsValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;

use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(FromString::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleFromSexadecimal::class)]
#[UsesClass(AngleGenerator::class)]
#[UsesClass(AngularDistance::class)]
#[UsesClass(AngularDistanceRange::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(DegreesGenerator::class)]
#[UsesClass(DegreesValidator::class)]
#[UsesClass(FloatGenerator::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(MinutesGenerator::class)]
#[UsesClass(MinutesValidator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(NoMatchException::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(RelativeAngularDistanceGenerator::class)]
#[UsesClass(RelativeAngularDistanceValidator::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(RelativeSexadecimalValidator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SecondsGenerator::class)]
#[UsesClass(SecondsRange::class)]
#[UsesClass(SecondsValidator::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexadecimalRange::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class FromStringTest extends TestCase
{
    public function test_can_create_positive_angle(): void
    {
        // Arrange
        $degrees = $this->randomDegrees();
        $minutes = $this->randomMinutes();
        $seconds = $this->randomSeconds(precision: 1);
        $direction = Rotation::COUNTER_CLOCKWISE;
        $sign = '';
        
        // Act
        $builder = new FromString("{$sign}{$degrees} {$minutes} {$seconds}");
        [$sexagesimal] = $builder->fetchData();
        
        //Assert
        $this->assertInstanceOf(SexagesimalDegrees::class, $sexagesimal);
        $this->assertDegrees($degrees, $sexagesimal->degrees);
        $this->assertMinutes($minutes, $sexagesimal->minutes);
        $this->assertSeconds($seconds, $sexagesimal->seconds);
        $this->assertDirection($direction, $sexagesimal->direction);
    }

    public function test_can_create_negative_angle(): void
    {
        // Arrange
        $degrees = $this->randomDegrees();
        $minutes = $this->randomMinutes();
        $seconds = $this->randomSeconds(precision: 1);
        $direction = Rotation::CLOCKWISE;
        $sign = '-';
        $builder = new FromString("{$sign}{$degrees} {$minutes} {$seconds}");
        
        // Act
        [$sexagesimal] = $builder->fetchData();
        
        //Assert
        $this->assertInstanceOf(SexagesimalDegrees::class, $sexagesimal);
        $this->assertDegrees($degrees, $sexagesimal->degrees);
        $this->assertMinutes($minutes, $sexagesimal->minutes);
        $this->assertSeconds($seconds, $sexagesimal->seconds);
        $this->assertDirection($direction, $sexagesimal->direction);
    }

    public function test_can_match_minutes_and_seconds(): void
    {
        // Arrage
        $minutes = $this->randomMinutes();
        $seconds = $this->randomSeconds();
        $measure = "{$minutes} {$seconds}";
        $builder = new FromString($measure);

        // Act
        [$sexagesimal] = $builder->fetchData();

        // Assert
        $this->assertInstanceOf(SexagesimalDegrees::class, $sexagesimal);
        $this->assertDegrees(new Degrees(0), $sexagesimal->degrees);
        $this->assertMinutes($minutes, $sexagesimal->minutes);
        $this->assertSeconds($seconds, $sexagesimal->seconds);
        $this->assertDirection(Rotation::COUNTER_CLOCKWISE, $sexagesimal->direction);
    }

    public function test_can_match_degrees_and_seconds(): void
    {
        // Arrage
        $degrees = $this->randomDegrees();
        $seconds = $this->randomSeconds();
        $measure = "{$degrees} {$seconds}";
        $builder = new FromString($measure);

        // Act
        [$sexagesimal] = $builder->fetchData();

        // Assert
        $this->assertInstanceOf(SexagesimalDegrees::class, $sexagesimal);
        $this->assertDegrees($degrees, $sexagesimal->degrees);
        $this->assertMinutes(new Minutes(0), $sexagesimal->minutes);
        $this->assertSeconds($seconds, $sexagesimal->seconds);
        $this->assertDirection(Rotation::COUNTER_CLOCKWISE, $sexagesimal->direction);
    }

    public function test_can_match_degrees_and_minutes(): void
    {
        // Arrage
        $degrees = $this->randomDegrees();
        $minutes = $this->randomMinutes();
        $measure = "{$degrees} {$minutes}";
        $builder = new FromString($measure);

        // Act
        [$sexagesimal] = $builder->fetchData();

        // Assert
        $this->assertInstanceOf(SexagesimalDegrees::class, $sexagesimal);
        $this->assertDegrees($degrees, $sexagesimal->degrees);
        $this->assertMinutes($minutes, $sexagesimal->minutes);
        $this->assertSeconds(new Seconds(0), $sexagesimal->seconds);
        $this->assertDirection(Rotation::COUNTER_CLOCKWISE, $sexagesimal->direction);
    }

    public function test_can_match_seconds(): void
    {
        // Arrange
        $seconds = $this->randomSeconds();
        $measure = "{$seconds}";
        $builder = new FromString($measure);

        // Act
        [$sexagesimal] = $builder->fetchData();

        // Assert
        $this->assertInstanceOf(SexagesimalDegrees::class, $sexagesimal);
        $this->assertDegrees(new Degrees(0), $sexagesimal->degrees);
        $this->assertMinutes(new Minutes(0), $sexagesimal->minutes);
        $this->assertSeconds($seconds, $sexagesimal->seconds);
        $this->assertDirection(Rotation::COUNTER_CLOCKWISE, $sexagesimal->direction);
    }
    
    public function test_no_match_exception(): void
    {
        // Assert
        $this->expectException(NoMatchException::class);

        // Arrange
        $measure = "adsjh1oi4jhljv";
        $builder = new FromString($measure);

        // Act
        $builder->fetchData();
    }
}