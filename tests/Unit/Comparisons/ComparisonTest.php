<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons;

use Error;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Degrees;
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
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\Dummy\UnknownAngularMeasure;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(Comparison::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngularMeasure::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Equal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(AngleGenerator::class)]
#[UsesClass(NegativeAngleGenerator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(RelativeAngleGenerator::class)]
#[UsesClass(SexadecimalRange::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(RelativeSexadecimalValidator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesClass(PositiveAngleGenerator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesTrait(WithAngleFaker::class)]
class ComparisonTest extends TestCase
{
    public function test_error(): void
    {
        // Assert
        $this->expectException(Error::class);

        // Arrange & Act
        new Equal(new UnknownAngularMeasure, $this->randomAngle());
    }
}