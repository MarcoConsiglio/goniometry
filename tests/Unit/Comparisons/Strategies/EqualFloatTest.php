<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualFloat;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The EqualFloat comparison strategy")]
#[CoversClass(EqualFloat::class)]
#[UsesClass(Angle::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class EqualFloatTest extends TestCase
{
    protected string $comparison = '=';

    #[TestDox("can compare an Angle and a sexadecimal angle measure.")]
    public function test_compare(): void
    {
        /**
         * Equal
         */
        // Arrange
        $precision = $this->randomPrecision();
        $alfa = $this->randomAngle();
        $beta = $alfa->toFloat($precision);
        $true_alfa = number_format($alfa->toFloat($precision), PHP_FLOAT_DIG);
        $true_beta = number_format($beta, PHP_FLOAT_DIG);

        // Act & Assert
        $this->assertTrue(new EqualFloat($alfa, $beta, $precision)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Not equal
         */
        // Arrange
        $alfa = $this->randomAngle(0, 180 - self::SSN);
        $beta = $this->randomSexadecimal(180);

        // Act & Assert
        $this->assertFalse(new EqualFloat($alfa, $beta, $precision)->compare(),
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