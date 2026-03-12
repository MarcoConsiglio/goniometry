<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromRadian;
use MarcoConsiglio\Goniometry\Casting\Radian\Cast;
use MarcoConsiglio\Goniometry\Casting\Radian\Round;
use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use RoundingMode;

#[TestDox("The FromRadian builder")]
#[CoversClass(FromRadian::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(Round::class)]
#[UsesClass(Sexagesimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Radian::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalDegrees::class)]
class FromRadianTest extends BuilderTestCase
{
    #[TestDox("can create an angle from a radian value.")]
    public function test_can_create_an_angle()
    {
        // Arrange
        $precision = PHP_FLOAT_DIG - 1;
        $radian_value = $this->randomRadian();

        // Act
        $angle = Angle::createFromRadian($radian_value);

        // Assert
        $this->assertEquals(
            round($radian_value, $precision, RoundingMode::HalfTowardsZero), 
            $angle->toRadian($precision)
        );
    }

    /**
     * Returns the FromRadian builder class.
     * @return string
     */
    protected function getBuilderClass(): string
    {
        return FromRadian::class;
    }
}