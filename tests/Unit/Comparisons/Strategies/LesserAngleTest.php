<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserAngle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The LesserAngle comparison strategy")]
#[CoversClass(LesserAngle::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDegrees::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
class LesserAngleTest extends TestCase
{    
    protected string $comparison = '<';

    #[TestDox("can compare two Angle instances.")]
    public function test_compare(): void
    {
        /**
         * Alfa degrees are less than beta degrees
         */
        // Arrange
        $alfa = Angle::createFromValues($this->randomDegrees(max: 179));
        $beta = Angle::createFromValues($this->randomDegrees(min: 180));

        // Act & Assert
        $this->assertTrue(new LesserAngle($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Alfa degrees are greater than beta degrees
         */
        // Arrange
        $alfa = Angle::createFromValues($this->randomDegrees(min: 180));
        $beta = Angle::createFromValues($this->randomDegrees(max: 179));

        // Act & Assert
        $this->assertFalse(new LesserAngle($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Alfa minutes are less than beta minutes
         */
        // Arrange
        $alfa = Angle::createFromValues(
            180, $this->randomMinutes(max: 30)
        );
        $beta = Angle::createFromValues(
            180, $this->randomMinutes(min: 29)
        );

        // Act & Assert
        $this->assertTrue(new LesserAngle($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Alfa minutes are greater than beta minutes
         */
        // Arrange
        $alfa = Angle::createFromValues(
            180, $this->randomMinutes(min: 30)
        );
        $beta = Angle::createFromValues(
            180, $this->randomMinutes(max: 29)
        );

        // Act & Assert
        $this->assertFalse(new LesserAngle($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Alfa seconds are less than beta seconds
         */
        // Arrange
        $alfa = Angle::createFromValues(
            180, 30, $this->randomSeconds(max: 29)
        );
        $beta = Angle::createFromValues(
            180, 30, $this->randomSeconds(min: 30)
        );

        // Act & Assert
        $this->assertTrue(new LesserAngle($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Alfa seconds are less than beta seconds
         */
        // Arrange
        $alfa = Angle::createFromValues(
            180, 30, $this->randomSeconds(max: 29)
        );
        $beta = Angle::createFromValues(
            180, 30, $this->randomSeconds(min: 30)
        );

        // Act & Assert
        $this->assertTrue(new LesserAngle($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );

        /**
         * Alfa seconds are greater or equal to beta seconds
         */
        // Arrange
        $alfa = Angle::createFromValues(
            180, 30, $this->randomSeconds(min: 30)
        );
        $beta = Angle::createFromValues(
            180, 30, $this->randomSeconds(max: 30)
        );

        // Act & Assert
        $this->assertFalse(new LesserAngle($alfa, $beta)->compare(),
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