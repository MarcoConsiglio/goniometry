<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterInt;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The GreaterInt comparison strategy")]
#[CoversClass(GreaterInt::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(FromDegrees::class)]
#[UsesClass(GreaterAngle::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalDegrees::class)]
class GreaterIntTest extends TestCase
{
    protected string $comparison = '>';
 
    #[TestDox("can compare an Angle and a sexagesimal degrees angle measure.")]
    public function test_compare(): void
    {
        /**
         * Greater
         */
        // Arrange
        $alfa = $this->randomAngle(min: 180);
        $beta = $this->randomDegrees(max: 179);

        // Act & Assert
        $this->assertTrue(new GreaterInt($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Lesser
         */
        $alfa = $this->randomAngle(max: 180 - self::SSN);
        $beta = $this->randomDegrees(min: 180);

        // Act & Assert
        $this->assertFalse(new GreaterInt($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Equal
         */
        // Arrange
        $alfa = Angle::createFromValues($beta = $this->randomDegrees());

        // Act & Assert
        $this->assertFalse(
            new GreaterInt($alfa, $beta)->compare(),
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