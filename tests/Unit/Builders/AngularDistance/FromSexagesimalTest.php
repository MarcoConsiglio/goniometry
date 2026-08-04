<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders\AngularDistance;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal as AngularDistanceFromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexagesimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Random\Generator\AngularDistance as AngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Degrees as DegreesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\FloatGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Minutes as MinutesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngularDistance as RelativeAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Seconds as SecondsGenerator;
use MarcoConsiglio\Goniometry\Random\SecondsRange;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Minutes as MinutesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeAngularDistance as RelativeAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Seconds as SecondsValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(FromSexagesimal::class)]
#[UsesClass(AngularDistance::class)]
#[UsesClass(AngularDistanceFromSexadecimal::class)]
#[UsesClass(AngularDistanceGenerator::class)]
#[UsesClass(AngularDistanceRange::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(DegreesGenerator::class)]
#[UsesClass(DegreesValidator::class)]
#[UsesClass(FloatGenerator::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(MinutesGenerator::class)]
#[UsesClass(MinutesValidator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(RelativeAngularDistanceGenerator::class)]
#[UsesClass(RelativeAngularDistanceValidator::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SecondsGenerator::class)]
#[UsesClass(SecondsRange::class)]
#[UsesClass(SecondsValidator::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class FromSexagesimalTest extends TestCase
{
    public function test_can_create_a_positive_angular_distance(): void
    {
        // Arrange
        $degrees = $this->randomDegrees(max: 179);
        $minutes = $this->randomMinutes();
        $seconds = $this->randomSeconds();
        $direction = Rotation::COUNTER_CLOCKWISE;
        $builder = new FromSexagesimal(
            $degrees->value(), 
            $minutes->value(), 
            $seconds->value(), 
            $direction
        );

        // Act
        $result = $builder->fetchData()[0];

        // Assert
        $this->assertInstanceOf(SexagesimalDegrees::class, $result);
        $this->assertDegrees($degrees, $result->degrees);
        $this->assertMinutes($minutes, $result->minutes);
        $this->assertSeconds($seconds, $result->seconds);
        $this->assertDirection($direction, $result->direction);
    }

    public function test_can_create_a_negative_angular_distance(): void
    {
        // Arrange
        $degrees = $this->randomDegrees(max: 179);
        $minutes = $this->randomMinutes();
        $seconds = $this->randomSeconds();
        $direction = Rotation::CLOCKWISE;
        $builder = new FromSexagesimal(
            $degrees->value(), 
            $minutes->value(), 
            $seconds->value(), 
            $direction
        );

        // Act
        $result = $builder->fetchData()[0];

        // Assert
        $this->assertInstanceOf(SexagesimalDegrees::class, $result);
        $this->assertDegrees($degrees, $result->degrees);
        $this->assertMinutes($minutes, $result->minutes);
        $this->assertSeconds($seconds, $result->seconds);
        $this->assertDirection($direction, $result->direction);
    }

    public function test_can_create_a_null_angle(): void
    {
        // Arrange
        $positive_direction = Rotation::COUNTER_CLOCKWISE;
        $negative_direction = Rotation::CLOCKWISE;

        // Act
        //  Null angles
        $alfa = AngularDistance::createFromValues(0, 0, 0, $positive_direction);
        $beta = AngularDistance::createFromValues(0, 0, 0, $negative_direction);
        //  Non-null angles
        $gamma =    AngularDistance::createFromValues(1, 0, 0, $negative_direction);
        $epsilon =  AngularDistance::createFromValues(0, 1, 0, $negative_direction);
        $iota =     AngularDistance::createFromValues(0, 0, 1, $negative_direction);
        // Assert
        //  Null angles
        $this->assertEquals($positive_direction, $alfa->direction);
        $this->assertEquals($positive_direction, $beta->direction);
        //  Non-null angles
        $this->assertEquals($negative_direction, $gamma->direction);
        $this->assertEquals($negative_direction, $epsilon->direction);
        $this->assertEquals($negative_direction, $iota->direction);
    }
}