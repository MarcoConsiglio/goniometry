<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Fuzzy;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\AbsoluteSum;
use MarcoConsiglio\Goniometry\Builders\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\SumBuilder;
use MarcoConsiglio\Goniometry\Comparisons\Fuzzy\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Fuzzy\Types\AngleType as FuzzyAngleType;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\ComparisonStrategy;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\Fuzzy\EqualAngle as FuzzyEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Types\AngleType;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\Angle as AngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngle as PositiveAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[TestDox("The fuzzy Equal comparison")]
#[CoversClass(Equal::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AbsoluteSum::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(SumBuilder::class)]
#[UsesClass(FuzzyAngleType::class)]
#[UsesClass(ComparisonStrategy::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(FuzzyEqualAngle::class)]
#[UsesClass(AngleType::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(AngleGenerator::class)]
#[UsesClass(PositiveAngleGenerator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class EqualTest extends TestCase
{
    #[TestDox("can compare two angle within a angle error.")]
    public function test_compare_angle(): void
    {
        // Arrange
        $alfa = $this->positiveRandomAngle();
        $beta = $this->positiveRandomAngle();
        $delta = $this->positiveRandomAngle();
        $comparison = new Equal($alfa, $beta, $delta);

        // Act & Assert
        $this->assertIsBool($comparison->compare());
    }
}