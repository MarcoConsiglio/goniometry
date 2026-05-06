<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders\Angle;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexagesimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexagesimal as RelativeSexagesimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Sexagesimal as SexagesimalGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
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

#[TestDox("The FromSexagesimal builder")]
#[CoversClass(FromSexagesimal::class)]
#[UsesClass(Angle::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(RelativeSexadecimalValidator::class)]
#[UsesClass(RelativeSexagesimalGenerator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexadecimalValidator::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesClass(SexagesimalGenerator::class)]
#[UsesTrait(WithAngleFaker::class)]
class FromSexagesimalTest extends TestCase
{
    #[TestDox("can create an angle from sexagesimal values.")]
    public function test_can_create_an_angle(): void
    {
        // Arrange
        $random = $this->randomSexagesimal(precision: 3);
        $builder = new FromSexagesimal(
            $random->degrees->value(),
            $random->minutes->value(),
            $random->seconds->value(),
            $random->direction
        );

        // Act
        $result = $builder->fetchData();
        $actual = $result[0];

        // Assert
        $this->assertInstanceOf(SexagesimalDegrees::class, $actual);
        $this->assertDegrees($random->degrees, $actual->degrees);
        $this->assertMinutes($random->minutes, $actual->minutes);
        $this->assertSeconds($random->seconds, $actual->seconds);
        $this->assertDirection($random->direction, $actual->direction);
    }

    #[TestDox("will always create a null angle with positive direction.")]
    public function test_can_create_a_null_angle(): void
    {
        // Arrange
        $positive_direction = Direction::COUNTER_CLOCKWISE;
        $negative_direction = Direction::CLOCKWISE;

        // Act
        //  Null angles
        $alfa = Angle::createFromValues(0, 0, 0, $positive_direction);
        $beta = Angle::createFromValues(0, 0, 0, $negative_direction);
        //  Non-null angles
        $gamma =    Angle::createFromValues(1, 0, 0, $negative_direction);
        $epsilon =  Angle::createFromValues(0, 1, 0, $negative_direction);
        $iota =     Angle::createFromValues(0, 0, 1, $negative_direction);
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