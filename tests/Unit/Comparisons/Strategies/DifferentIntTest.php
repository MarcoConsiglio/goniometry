<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromSexagesimal;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\DifferentInt;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualInt;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\Degrees as DegreesGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The DifferentInt comparison strategy")]
#[CoversClass(DifferentInt::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromSexagesimal::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(EqualInt::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
#[UsesClass(DegreesGenerator::class)]
#[UsesClass(DegreesValidator::class)]
class DifferentIntTest extends TestCase
{
    protected string $comparison = '≠';

    #[TestDox("can compare an Angle instance and a sexagesimal degrees angle measure.")]
    public function test_compare(): void
    {
        /**
         * Different
         */
        // Arrange
        $beta = $this->randomDegrees(min : 1);
        $alfa = Angle::createFromValues($beta->value() - 1);

        // Act & Assert
        $this->assertTrue(new DifferentInt($alfa, $beta->value())->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Equal
         */
        // Arrange
        $beta = $this->randomDegrees();
        $alfa = Angle::createFromValues($beta->value());

        // Act & Assert
        $this->assertFalse(new DifferentInt($alfa, $beta->value())->compare(),
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