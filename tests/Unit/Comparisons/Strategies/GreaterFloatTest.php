<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromSexadecimal;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterFloat;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngle as NegativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngle as PositiveAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngle as RelativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The GreaterFloat comparison strategy")]
#[CoversClass(GreaterFloat::class)]
#[UsesClass(Angle::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Direction::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(NegativeAngleGenerator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveAngleGenerator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(RelativeAngleGenerator::class)]
#[UsesClass(RelativeSexadecimalValidator::class)]
#[UsesClass(Round::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]

class GreaterFloatTest extends TestCase
{
    protected string $comparison = '>';

    #[TestDox("can compare an Angle and a sexadecimal angle measure.")]
    public function test_compare(): void
    {
        /**
         * Greater
         */
        // Arrange
        $alfa = $this->positiveRandomAngle(min: 180);
        $beta = $this->randomAngle(min: NextFloat::after(-180), max: NextFloat::before(180))->toFloat();

        // Act & Assert
        $this->assertTrue(new GreaterFloat($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Lesser
         */
        // Arrange
        $alfa = $this->positiveRandomAngle(max: NextFloat::before(180));
        $beta = $this->positiveRandomAngle(min: 180)->toFloat();

        // Act & Assert
        $this->assertFalse(new GreaterFloat($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Equal
         */
        $alfa = $this->randomAngle();
        $beta = (clone $alfa)->toFloat();

        // Act & Assert
        $this->assertFalse(new GreaterFloat($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );
    }

    /**
     * Return a fail message for this TestCase.
     */
    protected function getFailMessage(Angle $alfa, int|float|string|Angle $beta): string
    {
        return $this->comparisonFail($alfa, $this->comparison, $beta);
    }
}