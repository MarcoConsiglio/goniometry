<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DependsOnClass;
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
class GreaterAngleTest extends TestCase
{
    #[DependsOnClass(Degrees::class)]
    #[DependsOnClass(Minutes::class)]
    #[DependsOnClass(Seconds::class)]
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
        $this->assertTrue(new GreaterAngle($alfa, $beta)->compare());
        $this->assertTrue(new GreaterAngle($gamma, $delta)->compare());
        $this->assertTrue(new GreaterAngle($epsilon, $zeta)->compare());

        /**
         *  Less
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
}