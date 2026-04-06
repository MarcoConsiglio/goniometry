<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromSexadecimal;
use MarcoConsiglio\Goniometry\Builders\FromSexagesimal;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\Angle as AngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Degrees as DegreesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Minutes as MinutesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngle as NegativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngle as PositiveAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngle as RelativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Seconds as SecondsGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Minutes as MinutesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Seconds as SecondsValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The GreateAngle comparison strategy")]
#[CoversClass(GreaterAngle::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleGenerator::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(DegreesGenerator::class)]
#[UsesClass(DegreesValidator::class)]
#[UsesClass(Direction::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(FromSexagesimal::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(MinutesGenerator::class)]
#[UsesClass(MinutesValidator::class)]
#[UsesClass(NegativeAngleGenerator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveAngleGenerator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(RelativeAngleGenerator::class)]
#[UsesClass(RelativeSexadecimalValidator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SecondsGenerator::class)]
#[UsesClass(SecondsValidator::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexadecimalValidator::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class GreaterAngleTest extends TestCase
{
    protected string $comparison = '>';

    #[TestDox("can compare two Angle instances.")]
    public function test_compare(): void
    {
        /** 
         *  Greater 
         */
        // Arrange
        $alfa = Angle::createFromValues(
            degrees: $this->randomDegrees(min: 180)->value()
        );
        $beta = Angle::createFromValues(
            degrees: $this->randomDegrees(max: 179)->value()
        );
        $gamma = Angle::createFromValues(
            minutes: $this->randomMinutes(min: 30)->value()
        );
        $delta = Angle::createFromValues(
            minutes: $this->randomMinutes(max: 29)->value()
        );
        $epsilon = Angle::createFromValues(
            seconds: $this->randomSeconds(min: 30.0)->value()
        );
        $zeta = Angle::createFromValues(
            seconds: $this->randomSeconds(max: NextFloat::before(30.0))->value()
        );

        // Act & Assert
        $this->assertTrue(new GreaterAngle($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );
        $this->assertTrue(new GreaterAngle($gamma, $delta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );
        $this->assertTrue(new GreaterAngle($epsilon, $zeta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         *  Lesser
         */

        // Act & Assert
        $this->assertFalse(new GreaterAngle($beta, $alfa)->compare());
        $this->assertFalse(new GreaterAngle($delta, $gamma)->compare());
        $this->assertFalse(new GreaterAngle($zeta, $epsilon)->compare());

        /**
         *  Equal
         */
        // Arrange
        $alfa = $this->randomAngle();
        $beta = clone $alfa;

        // Act & Assert
        $this->assertFalse(new GreaterAngle($alfa, $beta)->compare());
    }

    /**
     * Return a fail message for this TestCase.
     */
    protected function getFailMessage(Angle $alfa, int|float|string|Angle $beta): string
    {
        return $this->comparisonFail($alfa, $this->comparison, $beta);
    }
}