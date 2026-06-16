<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders\AngularDistance;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal as AngleFromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromString;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Random\Generator\Angle as AngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngularDistance as RelativeAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeAngularDistance as RelativeAngularDistanceValidator;
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

#[CoversClass(FromString::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleFromSexadecimal::class)]
#[UsesClass(AngleGenerator::class)]
#[UsesClass(AngularDistance::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(RelativeSexadecimalValidator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexadecimalRange::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesClass(AngularDistanceRange::class)]
#[UsesClass(AngularDistance::class)]
#[UsesClass(RelativeAngularDistanceGenerator::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(RelativeAngularDistanceValidator::class)]
#[UsesTrait(WithAngleFaker::class)]
class FromStringTest extends TestCase
{
    public function test_create_from_string(): void
    {
        // Arrange
        $angle = $this->randomAngularDistance(precision: 3);
        $sexadecimal = new SexadecimalAngularDistance($angle->toSexadecimalDegrees()->value);
        $angular_distance = AngularDistance::createFromDecimal($sexadecimal);
        $builder = new FromString((string) $angle);

        // Act
        $result = $builder->fetchData();
        $actual = $result[0];

        // Assert
        $fail_message = $this->sexagesimalFail($angle->toSexagesimalDegrees(), $actual);
        $this->assertInstanceOf(SexagesimalDegrees::class, $result[0]);
        $this->assertDegrees($angular_distance->degrees, $actual->degrees, $fail_message);
        $this->assertMinutes($angular_distance->minutes, $actual->minutes, $fail_message);
        $this->assertSeconds($angular_distance->seconds, $actual->seconds, 3, $fail_message);
        $this->assertDirection($angular_distance->direction, $actual->direction, $fail_message);
    }
}