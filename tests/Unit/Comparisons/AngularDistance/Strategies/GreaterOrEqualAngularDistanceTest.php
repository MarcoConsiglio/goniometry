<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterOrEqualAngularDistance;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Random\Generator\AngularDistance as AngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngularDistance as RelativeAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeAngularDistance as RelativeAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\AngularDistance\Strategies\TestCase as StrategiesTestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(GreaterOrEqualAngularDistance::class)]
#[UsesClass(AngularDistance::class)]
#[UsesClass(AngularMeasure::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(GreaterAngle::class)]
#[UsesClass(EqualAngularDistance::class)]
#[UsesClass(GreaterAngularDistance::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(AngularDistanceRange::class)]
#[UsesClass(AngularDistanceGenerator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(RelativeAngularDistanceGenerator::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(RelativeAngularDistanceValidator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class GreaterOrEqualAngularDistanceTest extends StrategiesTestCase
{
    protected string $comparison = '≥';

    public function test_compare(): void
    {
        /**
         * Greater
         */
        // Arrange
        $alfa = $this->randomAngularDistance(min: 0);
        $beta = $this->randomAngularDistance(max: NextFloat::beforeZero());

        // Act & Assert
        $this->assertTrue(
            new GreaterOrEqualAngularDistance($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Equal
         */
        // Arrange
        $alfa = $this->randomAngularDistance();
        $beta = clone $alfa;

        // Act & Assert
        $this->assertTrue(
            new GreaterOrEqualAngularDistance($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Lesser
         */
        // Arrange
        $alfa = $this->randomAngularDistance(max: NextFloat::beforeZero());
        $beta = $this->randomAngularDistance(min: 0);

        // Act & Assert
        $this->assertFalse(
            new GreaterOrEqualAngularDistance($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );
    }
} 