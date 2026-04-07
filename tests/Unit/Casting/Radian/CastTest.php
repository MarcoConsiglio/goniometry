<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Casting\Radian;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromSexadecimal;
use MarcoConsiglio\Goniometry\Casting\Radian\Cast;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\Angle as AngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngle as NegativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngle as PositiveAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngle as RelativeAngleGenerator;
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

#[TestDox("The Radian\Cast class")]
#[CoversClass(Cast::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleGenerator::class)]
#[UsesClass(Degrees::class)]
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
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexadecimalValidator::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class CastTest extends TestCase
{
    #[TestDox("can cast an Angle to radian with a specified precision.")]
    public function test_cast_with_precision(): void
    {
        // Arrange
        $precision = $this->randomPrecision();
        if ($precision >= 2) $precision -= 2;
        $angle = $this->randomAngle($precision + 2);
        $sexadecimal = $angle->toSexadecimalDegrees();
        $radian = $sexadecimal->value->toRadian()->toFloat($precision);

        // Act
        $actual_radian = $angle->toRadian($precision);

        // Assert
        $this->assertSame($radian, $actual_radian,
            "{$sexadecimal} = {$radian} but expected radian {$radian} ≠ {$actual_radian} actual radian using precision $precision."
        );
    }

    public function test_cast_without_precision(): void
    {
        // Arrange
        $angle = $this->randomAngle(precision: 3);
        $sexadecimal = $angle->toSexadecimalDegrees();
        $radian = $sexadecimal->value->toRadian()->toFloat();

        // Act
        $actual_radian = $angle->toRadian();

        // Assert
        $this->assertSame($radian, $actual_radian,
            "{$sexadecimal} = {$radian} but expected radian {$radian} ≠ {$actual_radian} actual radian."
        );
    }
}