<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Casting\Sexadecimal;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal as AngularDistanceFromSexadecimal;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Cast;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\Angle as AngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\AngularDistance as AngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngle as NegativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngle as PositiveAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngle as RelativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngularDistance as RelativeAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeAngularDistance as RelativeAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The Sexadecimal\Cast class")]
#[CoversClass(Cast::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(Direction::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
#[UsesClass(AngleGenerator::class)]
#[UsesClass(PositiveAngleGenerator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(RelativeAngleGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(SexadecimalValidator::class)]
#[UsesClass(NegativeAngleGenerator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(RelativeSexadecimalValidator::class)]
#[UsesClass(AngularDistance::class)]
#[UsesClass(AngularDistanceFromSexadecimal::class)]
#[UsesClass(Round::class)]
#[UsesClass(AngularDistanceGenerator::class)]
#[UsesClass(RelativeAngularDistanceGenerator::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(RelativeAngularDistanceValidator::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
class CastTest extends TestCase
{
    protected Angle $angle;

    protected SexadecimalDegrees $sexadecimal;

    protected int $precision;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->precision = $this->randomPrecision();
        if ($this->precision >= 2) $this->precision -= 2;
        $this->angle = $this->randomAngle(
            precision: $this->precision < 2 ? $this->precision + 2 : $this->precision
        );
        $this->sexadecimal = $this->angle->toSexadecimalDegrees();
    }

    #[TestDox("can cast the Angle to a sexadecimal value with a specific precision.")]
    public function test_cast_with_precision(): void
    {
        // Arrange
        $sexadecimal = $this->sexadecimal->value($this->precision);

        // Act
        $float = new Cast($this->angle, $this->precision)->cast();

        // Assert
        $this->assertSame($sexadecimal, $float, "$sexadecimal ≠ $float with $this->precision digit precision");
    }

    #[TestDox("can cast the Angle to a sexadecimal value without a specific precision.")]
    public function test_cast_without_precision(): void
    {
        // Arrange
        $sexadecimal = $this->sexadecimal->value();

        // Act
        $float = new Cast($this->angle)->cast();

        // Assert
        $this->assertSame($sexadecimal, $float, "$sexadecimal ≠ $float");
    }

    public function test_cast_to_SexadecimalAngularDistance(): void
    {
        // Arrange
        $sexadecimal_angular_distance = $this->randomAngularDistance()->toFloat();

        // Act
        $float = new Cast(
            AngularDistance::createFromDecimal($sexadecimal_angular_distance),
            PHP_FLOAT_DIG + 1
        )->cast();

        // Assert
        $this->assertSame($sexadecimal_angular_distance, $float, 
            "$sexadecimal_angular_distance ≠ $float"
        );
    }
}