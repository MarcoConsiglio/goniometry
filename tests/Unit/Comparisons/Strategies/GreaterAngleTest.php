<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The GreateAngle comparison strategy")]
#[CoversClass(GreaterAngle::class)]
#[UsesClass(Angle::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(FromDegrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class GreaterAngleTest extends ComparisonStrategiesTestCase
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
            degrees: $this->randomDegrees(min: 180)
        );
        $beta = Angle::createFromValues(
            degrees: $this->randomDegrees(max: 179)
        );
        $gamma = Angle::createFromValues(
            minutes: $this->randomMinutes(min: 30)
        );
        $delta = Angle::createFromValues(
            minutes: $this->randomMinutes(max: 29)
        );
        $epsilon = Angle::createFromValues(
            seconds: $this->randomSeconds(min: 30.0)
        );
        $zeta = Angle::createFromValues(
            seconds: $this->randomSeconds(max: 30.0 - self::SSN)
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
        return $this->getComparisonFailMessage($alfa, $this->comparison, $beta);
    }
}