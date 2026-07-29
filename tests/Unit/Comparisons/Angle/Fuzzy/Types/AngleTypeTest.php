<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Angle\Fuzzy\Types;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\Angle\AbsoluteSum;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\Angle\SumBuilder;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy\Types\AngleType;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\Fuzzy\EqualAngle as FuzzyEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\ComparisonStrategy;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\Angle as AngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngle as PositiveAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngle;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(AngleType::class)]
#[UsesClass(AbsoluteSum::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleGenerator::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(FuzzyEqualAngle::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(PositiveAngleGenerator::class)]
#[UsesClass(PositiveSexadecimal::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalRange::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesClass(SexadecimalAngle::class)]
#[UsesClass(SumBuilder::class)]
#[UsesTrait(WithAngleFaker::class)]
class AngleTypeTest extends TestCase
{
    public function test_fuzzy_equal_strategy(): void
    {
        // Arrange
        $alfa = $this->positiveRandomAngle();
        $beta = $this->positiveRandomAngle();
        $delta = $this->positiveRandomAngle();
        $input_type = new AngleType($beta, $delta);

        // Act
        $strategy = $input_type
            ->setDelta($delta)
            ->getStrategyFor(
                $this->createStub(Equal::class),
                $alfa
            );

        // Assert
        $this->assertInstanceOf(FuzzyEqualAngle::class, $strategy);
    }
}