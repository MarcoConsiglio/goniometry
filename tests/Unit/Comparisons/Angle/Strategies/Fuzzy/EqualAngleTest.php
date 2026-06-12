<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Angle\Strategies\Fuzzy;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\Angle\AbsoluteSum;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\Angle\SumBuilder;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round;
use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\Comparisons\Comparison as GeneralComparison;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\LesserOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\Fuzzy\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\AngleType;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\Angle as AngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngle as PositiveAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
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

#[TestDox("The EqualAngle fuzzy comparison strategy")]
#[CoversClass(EqualAngle::class)]
#[UsesClass(AbsoluteSum::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleGenerator::class)]
#[UsesClass(AngleType::class)]
#[UsesClass(GeneralComparison::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(FromSexagesimal::class)]
#[UsesClass(Greater::class)]
#[UsesClass(GreaterAngle::class)]
#[UsesClass(GreaterOrEqual::class)]
#[UsesClass(GreaterOrEqualAngle::class)]
#[UsesClass(LesserAngle::class)]
#[UsesClass(LesserOrEqual::class)]
#[UsesClass(LesserOrEqualAngle::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(PositiveAngleGenerator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(Round::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexadecimalRange::class)]
#[UsesClass(Sexagesimal::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesClass(SumBuilder::class)]
#[UsesTrait(WithAngleFaker::class)]
class EqualAngleTest extends TestCase
{
    protected string $comparison = '≅';

    #[TestDox("can compare two Angle instances within a delta error.")]
    public function test_compare_angles(): void
    {
        /**
         * $beta = 0°
         */
        // Arrange
        $delta = Angle::createFromValues($delta_value = 4);
        $alfa = $this->positiveRandomAngle(min: $min = Degrees::MAX - $delta_value / 2);
        $beta = Angle::createFromValues(0);
        $gamma = $this->positiveRandomAngle(max: $max = $delta_value / 2);
        $epsilon = $this->positiveRandomAngle(min: NextFloat::after($min), max: NextFloat::before($max));

        // Act & Assert
        $this->assertTrue(new EqualAngle($alfa, $beta, $delta)->compare());
        $this->assertTrue(new EqualAngle($gamma, $beta, $delta)->compare());
        $this->assertFalse(new EqualAngle($epsilon, $beta, $delta)->compare());

        /**
         * $beta = 180°
         */
        // Arrange
        $alfa = $this->positiveRandomAngle(
            min: $min = 180 - $delta_value / 2, 
            max: $max = 180 + $delta_value / 2
        );
        $beta = Angle::createFromValues(180);
        $gamma = $this->positiveRandomAngle(max: NextFloat::before($min));
        $epsilon = $this->positiveRandomAngle(min: NextFloat::after($max));

        // Act & Assert
        $this->assertTrue(new EqualAngle($alfa, $beta, $delta)->compare());
        $this->assertFalse(new EqualAngle($gamma, $beta, $delta)->compare());
        $this->assertFalse(new EqualAngle($epsilon, $beta, $delta)->compare());
    }

    /**
     * Return a fail message for this `TestCase`.
     */
    protected function getFailMessage(AngleInterface $alfa, AngleInterface $beta, AngleInterface $delta): string
    {
        return $this->fuzzyComparisonFail($alfa, $this->comparison, $beta, $delta);
    }

    /**
     * Divide `$delta` by 2.
     */
    protected function getEpsilon(AngleInterface $delta): Angle
    {
        return Angle::createFromDecimal(
            new SexadecimalDegrees(
                $delta->toSexadecimalDegrees()->value->div(2)
            )
        );
    }

    /**
     * Calc the delta extremes.
     * 
     * @return array<Angle,Angle>
     */
    protected function getDeltaExtremes(Angle $beta, Angle $delta): array
    {
        $epsilon = $this->getEpsilon($delta);
        $min = $beta->absSum($epsilon->oppositeRotation());
        $max = $beta->absSum($epsilon);
        return [$min, $max];
    }
}