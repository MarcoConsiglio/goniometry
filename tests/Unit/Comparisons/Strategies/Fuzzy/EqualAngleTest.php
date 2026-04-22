<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies\Fuzzy;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\AbsoluteSum;
use MarcoConsiglio\Goniometry\Builders\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\FromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\SumBuilder;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round;
use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\LesserOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\Fuzzy\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserOrEqualAngle;
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

#[TestDox("The EqualAngle fuzzy comparison strategy")]
#[CoversClass(EqualAngle::class)]
#[UsesClass(AbsoluteSum::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleGenerator::class)]
#[UsesClass(AngleType::class)]
#[UsesClass(Comparison::class)]
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
#[UsesClass(Sexagesimal::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesClass(SumBuilder::class)]
#[UsesTrait(WithAngleFaker::class)]
class EqualAngleTest extends TestCase
{
    protected string $comparison = '≅';

    #[TestDox("can compare two Angle instance within a delta error.")]
    public function test_compare(): void
    {
        /**
         * Equal
         */
        // Arrange
        $delta = $this->positiveRandomAngle(max: 180);
        $beta = $this->positiveRandomAngle();
        [$min, $max] = $this->getDeltaExtremes($beta, $delta);
        if ($min->gt($max))
            $alfa = self::$faker->randomElement([
                $this->positiveRandomAngle(min: $min->toFloat(), max: NextFloat::before(Degrees::MAX)),
                $this->positiveRandomAngle(max: $max->toFloat())
            ]);
        else
            $alfa = $this->positiveRandomAngle($min->toFloat(),$max->toFloat());

        // Act & Assert
        $this->assertTrue(
            new EqualAngle($alfa, $beta, $delta)->compare(),
            $this->getFailMessage($alfa, $beta, $delta)
        );

        /**
         * Different
         */
        $delta = $this->positiveRandomAngle(max: 180);
        $beta = $this->positiveRandomAngle();
        [$min, $max] = $this->getDeltaExtremes($beta, $delta);
        if ($min->gt($max))
            $alfa = $this->positiveRandomAngle(
                min: NextFloat::before($max->toFloat()),
                max: NextFloat::after($min->toFloat())
            );
        else
            $alfa = self::$faker->randomElement([
                $this->positiveRandomAngle(max: NextFloat::before($min->toFloat())),
                $this->positiveRandomAngle(
                    min: NextFloat::after($max->toFloat()),
                    max: NextFloat::before(Degrees::MAX)
                )
            ]);
    }

    /**
     * Return a fail message for this `TestCase`.
     */
    protected function getFailMessage(Angle $alfa, Angle $beta, Angle $delta): string
    {
        return $this->fuzzyComparisonFail($alfa, $this->comparison, $beta, $delta);
    }

    /**
     * Divide `$delta` by 2.
     */
    protected function getEpsilon(Angle $delta): Angle
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
        $min = Angle::absSum($beta, $epsilon->toggleDirection());
        $max = Angle::absSum($beta, $epsilon);
        return [$min, $max];
    }
}