<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromSexadecimal;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\DifferentAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The DifferentAngle comparison strategy")]
#[CoversClass(DifferentAngle::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(EqualAngle::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(Direction::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class DifferentAngleTest extends TestCase
{
    protected string $comparison = '≠';

    #[TestDox("can compare two Angle instances.")]
    public function test_compare(): void
    {
        /**
         * Different
         */
        // Arrange
        $alfa = $this->randomAngle(max: 180 - self::SSN);
        $beta = $this->randomAngle(min: 180);

        // Act & Assert
        $this->assertTrue(
            new DifferentAngle($alfa, $beta)->compare(),
            $this->getFailMessage($alfa, $beta)
        );
        /**
         * Equal
         */
        $alfa = $this->randomAngle();
        $beta = clone $alfa;

        // Act & Assert
        $this->assertFalse(
            new DifferentAngle($alfa, $beta)->compare(),
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