<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexagesimal as AngleFromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexagesimal;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualInt as AngleEqualInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\DifferentInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualInt as AngularDistanceEqualInt;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Random\Generator\AngularDistance as AngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngularDistance as RelativeAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeAngularDistance as RelativeAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(DifferentInt::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleEqualInt::class)]
#[UsesClass(AngleFromSexagesimal::class)]
#[UsesClass(AngularDistance::class)]
#[UsesClass(AngularDistanceEqualInt::class)]
#[UsesClass(AngularDistanceGenerator::class)]
#[UsesClass(AngularDistanceRange::class)]
#[UsesClass(AngularMeasure::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(EqualAngularDistance::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(FromSexagesimal::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(RelativeAngularDistanceGenerator::class)]
#[UsesClass(RelativeAngularDistanceValidator::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class DifferentIntTest extends TestCase
{
    protected string $comparison = "≠";

    public function test_compare(): void
    {
        /**
         * Different
         */
        // Arrange
        $alfa = $this->randomAngularDistance();
        $beta = $this->randomInteger();

        // Act & Assert
        $this->assertTrue(
            new DifferentInt($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Equal
         */
        // Arrange
        $beta = $this->randomInteger(AngularDistance::MIN, AngularDistance::MAX);
        $alfa = AngularDistance::createFromValues(
            degrees: $beta,
            direction: $beta >= 0 ?
                Rotation::COUNTER_CLOCKWISE : 
                Rotation::CLOCKWISE
        );

        // Act & Assert
        $this->assertFalse(
            new DifferentInt($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

    }

    /**
     * Return a fail message for this TestCase.
     */
    protected function getFailMessage(AngularDistance $alfa, int|float|string|AngularDistance $beta): string
    {
        return $this->comparisonFail($alfa, $this->comparison, $beta);
    }
}