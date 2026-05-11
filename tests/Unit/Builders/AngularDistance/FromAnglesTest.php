<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders\AngularDistance;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromAngles;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\Angle as AngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngle as NegativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngle as PositiveAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngle as RelativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(FromAngles::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleGenerator::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(NegativeAngleGenerator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveAngleGenerator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(RelativeAngleGenerator::class)]
#[UsesClass(RelativeSexadecimalValidator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexadecimalRange::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class FromAnglesTest extends TestCase
{
    public function test_can_create_from_angles(): void
    {
        // Arrange
        $alfa = $this->randomAngle();
        $beta = $this->randomAngle();
        $distance_1 = $alfa->toSexadecimalDegrees()->value->sub(
            $beta->toSexadecimalDegrees()->value
        )->abs();
        $distance_2 = new Number(Degrees::MAX)->sub($distance_1);
        $expected_distance = Number::min($distance_1, $distance_2);
        if ($expected_distance->gte(180))
            $expected_distance = new Number(-Degrees::MAX)->plus($expected_distance);
        if ($expected_distance->lte(-180))
            $expected_distance = new Number(Degrees::MAX)->plus($expected_distance);
        $builder = new FromAngles($alfa, $beta);

        // Act
        $result = $builder->fetchData();
        $actual_distance = $result[1];
        $sexagesimal = $result[0];

        // Assert
        $this->assertInstanceOf(SexagesimalDegrees::class, $sexagesimal);
        $this->assertInstanceOf(SexadecimalAngularDistance::class, $actual_distance);
        $this->assertEquals(
            $expected_distance->value, 
            $actual_distance->value->value,
            "α = {$alfa}\nβ = {$beta}"
        );
    }

    public function test_specific_case(): void
    {
        // Arrange
        $alfa = Angle::createFromValues(287, 47, 38.141259503424, Direction::CLOCKWISE);
        $beta = Angle::createFromValues(330, 31, 34.630993667064, Direction::COUNTER_CLOCKWISE);
        $distance_1 = $alfa->toSexadecimalDegrees()->value->sub(
            $beta->toSexadecimalDegrees()->value
        )->abs();
        $distance_2 = new Number(Degrees::MAX)->sub($distance_1);
        $expected_distance = Number::min($distance_1, $distance_2);
        if ($expected_distance->gte(180))
            $expected_distance = new Number(-Degrees::MAX)->plus($expected_distance);
        if ($expected_distance->lte(-180))
            $expected_distance = new Number(Degrees::MAX)->plus($expected_distance);
        $builder = new FromAngles($alfa, $beta);

        // Act
        $result = $builder->fetchData();
        $actual_distance = $result[1];
        $sexagesimal = $result[0];

        // Assert
        $this->assertInstanceOf(SexagesimalDegrees::class, $sexagesimal);
        $this->assertInstanceOf(SexadecimalAngularDistance::class, $actual_distance);
        $this->assertEquals(
            $expected_distance->value, 
            $actual_distance->value->value,
            "α = {$alfa}\nβ = {$beta}"
        );
    }
}