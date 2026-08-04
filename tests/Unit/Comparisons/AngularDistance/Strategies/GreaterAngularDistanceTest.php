<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexagesimal;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterAngularDistance;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Random\Generator\AngularDistance as AngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Degrees as DegreesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\FloatGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Minutes as MinutesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngularDistance as RelativeAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Seconds as SecondsGenerator;
use MarcoConsiglio\Goniometry\Random\SecondsRange;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Minutes as MinutesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeAngularDistance as RelativeAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Seconds as SecondsValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Strategies\TestCase as StrategiesTestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(GreaterAngularDistance::class)]
#[UsesClass(AngularDistance::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(FromSexagesimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(AngularDistanceRange::class)]
#[UsesClass(AngularDistanceGenerator::class)]
#[UsesClass(DegreesGenerator::class)]
#[UsesClass(FloatGenerator::class)]
#[UsesClass(MinutesGenerator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(RelativeAngularDistanceGenerator::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(DegreesValidator::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(MinutesValidator::class)]
#[UsesClass(SecondsGenerator::class)]
#[UsesClass(SecondsRange::class)]
#[UsesClass(RelativeAngularDistanceValidator::class)]
#[UsesClass(SecondsValidator::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class GreaterAngularDistanceTest extends StrategiesTestCase
{
    protected string $comparison = '>';

    public function test_compare(): void
    {
        // Arrange
        $negative = Rotation::CLOCKWISE;
        $alfa = $this->randomAngularDistance(min: 0, max: AngularDistanceRange::max());
        $beta = $this->randomAngularDistance(min: AngularDistanceRange::min(), max: NextFloat::beforeZero());
        $gamma = AngularDistance::createFromValues(
            degrees: $this->randomDegrees(min: 90, max: 179)->value()
        );
        $delta = AngularDistance::createFromValues(
            degrees: $this->randomDegrees(min: 0, max: 89)->value()
        );
        $epsilon = AngularDistance::createFromValues(
            minutes: $this->randomMinutes(min: 30)->value()
        );
        $zeta = AngularDistance::createFromValues(
            minutes: $this->randomMinutes(max: 29)->value()
        );
        $eta = AngularDistance::createFromValues(
            seconds: $this->randomSeconds(min: 30.0)->value()
        );
        $theta = AngularDistance::createFromValues(
            seconds: $this->randomSeconds(max: NextFloat::before(30.0))->value()
        );
        $iota = $this->randomAngularDistance(max: NextFloat::beforeZero());
        $kappa = $this->randomAngularDistance(min: 0);
        $lambda = AngularDistance::createFromValues(
            degrees: $this->randomDegrees(min: 90, max: 179)->value(),
            direction: $negative
        );
        $mu = AngularDistance::createFromValues(
            degrees: $this->randomDegrees(min: 0, max: 89)->value(),
            direction: $negative
        );
        $nu = AngularDistance::createFromValues(
            degrees: 90,
            minutes: $this->randomMinutes(min: 30)->value(),
            direction: $negative
        );
        $xi = AngularDistance::createFromValues(
            degrees: 90,
            minutes: $this->randomMinutes(max: 29)->value(),
            direction: $negative
        );
        $omicron = AngularDistance::createFromValues(
            degrees: 90,
            minutes: 30,
            seconds: $this->randomSeconds(min: 30.0)->value(),
            direction: $negative
        );
        $pi = AngularDistance::createFromValues(
            degrees: 90,
            minutes: 30,
            seconds: $this->randomSeconds(max: NextFloat::before(30.0))->value(),
            direction: $negative
        );

        /**
         * Greater
         */
        // Act & Assert
        $this->assertTrue(
            new GreaterAngularDistance($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );
        $this->assertTrue(
            new GreaterAngularDistance($gamma, $delta)->compare(),
            $this->getFailMessage($gamma, $delta)
        );
        $this->assertTrue(
            new GreaterAngularDistance($epsilon, $zeta)->compare(),
            $this->getFailMessage($epsilon, $zeta)
        );
        $this->assertTrue(
            new GreaterAngularDistance($eta, $theta)->compare(),
            $this->getFailMessage($eta, $theta)
        );

        /**
         * Lesser
         */
        // Act & Assert
        $this->assertFalse(
            new GreaterAngularDistance($iota, $kappa)->compare(),
            $this->getFailMessage($iota, $kappa)
        );
        $this->assertFalse(
            new GreaterAngularDistance($lambda, $mu)->compare(),
            $this->getFailMessage($lambda, $mu)
        );
        $this->assertFalse(
            new GreaterAngularDistance($nu, $xi)->compare(),
            $this->getFailMessage($nu, $xi)
        );
        $this->assertFalse(
            new GreaterAngularDistance($omicron, $pi)->compare(),
            $this->getFailMessage($omicron, $pi)
        );
    }

    public function test_negative_and_positive_180_degrees_are_equal(): void
    {
        // Arrange
        $alfa = AngularDistance::createFromValues(180, direction: Rotation::COUNTER_CLOCKWISE);
        $beta = AngularDistance::createFromValues(180, direction: Rotation::CLOCKWISE);

        // Act & Assert
        $this->assertFalse(
            new GreaterAngularDistance($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );
    }
}