<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\Angle\AbsoluteSum;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\Angle as AngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngle as NegativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngle as PositiveAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngle as RelativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
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

#[TestDox("The AbsoluteSum SumBuilder")]
#[CoversClass(AbsoluteSum::class)]
#[UsesClass(Angle::class)]
#[UsesClass(AngleGenerator::class)]
#[UsesClass(Degrees::class)]
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
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexadecimalValidator::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class AbsoluteSumTest extends TestCase
{
    #[TestDox("can sum two Angles and return an absolute sum.")]
    public function test_can_sum_angles(): void
    {
        /**
         * Positive sum
         */
        // Arrange
        $alfa = $this->positiveRandomAngle(precision: 1);
        $beta = $this->positiveRandomAngle(precision: 1);
        $sum = 
            $alfa->toSexadecimalDegrees()->value
            ->plus($beta->toSexadecimalDegrees()->value)
            ->plus(Degrees::MAX);
        $expected_sum = new SexadecimalDegrees($sum);
        $gamma = Angle::createFromDecimal($expected_sum);

        // Act
        $actual_sum = new AbsoluteSum($alfa, $beta)->fetchData();
        $sexagesimal = $actual_sum[0];

        // Assert
        $this->assertInstanceOf(SexagesimalDegrees::class, $sexagesimal);
        $this->assertDegrees($gamma->degrees, $sexagesimal->degrees);
        $this->assertMinutes($gamma->minutes, $sexagesimal->minutes);
        $this->assertSeconds($gamma->seconds, $sexagesimal->seconds);
        $this->assertDirection($gamma->direction, $sexagesimal->direction);

        /**
         * Negative sum
         */
        // Arrange
        $alfa = $this->negativeRandomAngle(min: NextFloat::after(-180), precision: 1);
        $beta = $this->negativeRandomAngle(min: NextFloat::after(-180), precision: 1);
        $sum =
            $alfa->toSexadecimalDegrees()->value
            ->plus($beta->toSexadecimalDegrees()->value);
        $sum = new Number(Degrees::MAX)->add($sum);
        $expected_sum = new SexadecimalDegrees($sum);
        $gamma = Angle::createFromDecimal($expected_sum);

        // Act
        $actual_sum = new AbsoluteSum($alfa, $beta)->fetchData();
        $sexagesimal = $actual_sum[0];

        // Assert
        $this->assertInstanceOf(SexagesimalDegrees::class, $sexagesimal);
        $this->assertDegrees($gamma->degrees, $sexagesimal->degrees);
        $this->assertMinutes($gamma->minutes, $sexagesimal->minutes);
        $this->assertSeconds($gamma->seconds, $sexagesimal->seconds);
        $this->assertDirection($gamma->direction, $sexagesimal->direction);
    }
}