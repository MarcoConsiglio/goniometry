<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\FromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\FromString;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\ComparisonStrategy;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\DifferentAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\DifferentFloat;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\DifferentInt;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\DifferentString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualInt;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\FloatComparisonStrategy;
use MarcoConsiglio\Goniometry\Comparisons\Types\AngleType;
use MarcoConsiglio\Goniometry\Comparisons\Types\FloatType;
use MarcoConsiglio\Goniometry\Comparisons\Types\IntType;
use MarcoConsiglio\Goniometry\Comparisons\Types\StringType;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\Angle as AngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Degrees as DegreesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngle as NegativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngle as PositiveAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngle as RelativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The Different comparison")]
#[CoversClass(Different::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleGenerator::class)]
#[UsesClass(AngleType::class)]
#[UsesClass(ComparisonStrategy::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(DegreesGenerator::class)]
#[UsesClass(DegreesValidator::class)]
#[UsesClass(DifferentAngle::class)]
#[UsesClass(DifferentFloat::class)]
#[UsesClass(DifferentInt::class)]
#[UsesClass(DifferentString::class)]
#[UsesClass(Direction::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(EqualFloat::class)]
#[UsesClass(EqualInt::class)]
#[UsesClass(FloatComparisonStrategy::class)]
#[UsesClass(FloatType::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(FromSexagesimal::class)]
#[UsesClass(FromString::class)]
#[UsesClass(IntType::class)]
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
#[UsesClass(SexagesimalDegrees::class)]
#[UsesClass(StringType::class)]
#[UsesTrait(WithAngleFaker::class)]
class DifferentTest extends TestCase
{
    protected Angle $alfa;

    protected Angle $beta;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->alfa = $this->randomAngle();
        $this->beta = $this->randomAngle();
    }

    #[TestDox("can compare against an Angle.")]
    public function test_compare_angle(): void
    {
        // Act & Assert
        $comparison = new Different($this->alfa, $this->beta);
        $this->assertIsBool($comparison->compare());
    }

    #[TestDox("can compare against an int.")]
    public function test_compare_int(): void
    {
        // Act & Assert
        $comparison = new Different($this->alfa, $this->randomDegrees()->value());
        $this->assertIsBool($comparison->compare());
    }

    #[TestDox("can compare against a float with precision.")]
    public function test_compare_float(): void
    {
        // Act & Assert
        $comparison = new Different(
            $this->alfa, 
            $this->randomFloat()
        );
        $comparison->setPrecision($this->randomPrecision());
        $this->assertIsBool($comparison->compare());
    }

    #[TestDox("can compare against a string.")]
    public function test_compare_string(): void
    {
        // Act & Assert
        $comparison = new Different($this->alfa, (string) $this->beta);
        $this->assertIsBool($comparison->compare());       
    }
}