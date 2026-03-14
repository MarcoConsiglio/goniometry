<?php declare(strict_types=1);
namespace MarcoConsiglio\Goniometry\Tests\Unit;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\AngleBuilder;
use MarcoConsiglio\Goniometry\Builders\FromAnglesToRelativeSum;
use MarcoConsiglio\Goniometry\Builders\FromDecimal;
use MarcoConsiglio\Goniometry\Builders\FromDegrees;
use MarcoConsiglio\Goniometry\Builders\FromRadian;
use MarcoConsiglio\Goniometry\Builders\FromString;
use MarcoConsiglio\Goniometry\Builders\SumBuilder;
use MarcoConsiglio\Goniometry\Casting\Radian\Cast as CastToRadian;
use MarcoConsiglio\Goniometry\Casting\Radian\Round as RoundFromRadian;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Cast as CastToSexadecimal;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round as RoundFromSexadecimal;
use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("An Angle")]
#[CoversClass(Angle::class)]
#[UsesClass(AngleBuilder::class)]
#[UsesClass(FromDecimal::class)]
#[UsesClass(FromDegrees::class)]
#[UsesClass(FromRadian::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(Sexagesimal::class)]
#[UsesClass(RoundFromSexadecimal::class)]
#[UsesClass(CastToSexadecimal::class)]
#[UsesClass(Radian::class)]
#[UsesClass(RoundFromRadian::class)]
#[UsesClass(CastToRadian::class)]
#[UsesClass(SexadecimalDegrees::class)]
class AngleTest extends TestCase
{
    #[TestDox("which is exactly 0° has always counter-clockwise direction.")]
    public function test_null_angle_direction(): void
    {
        // Arrange
        $alfa = Angle::createFromValues(0, 0, 0, Direction::CLOCKWISE);

        // Assert
        $this->assertEquals(Direction::COUNTER_CLOCKWISE, $alfa->direction);
    }

    #[TestDox("created from radian return the same radian when casted to radian without precision.")]
    public function test_create_from_radian_cast_to_radian_without_precision(): void
    {
        // Arrange
        $radian = $this->randomRadian();
        $angle = Angle::createFromRadian($radian);

        // Act & Assert
        $this->assertEquals($radian, $actual = $angle->toRadian(), 
            $this->getCastToRadianFailMessage($radian, $actual)
        );
    }

    #[TestDox("created from radian can be casted to radian with a specific precision.")]
    public function test_create_from_radian_cast_to_radian_with_precision(): void
    {
        // Arrange
        $precision = $this->randomPrecision();
        $radian = $this->randomRadian(precision: $precision);
        $angle = Angle::createFromRadian($radian);

        // Act & Assert
        $this->assertEquals(
            $radian, 
            $actual = $angle->toRadian($precision), 
            $this->getCastToRadianFailMessage($radian, $actual, precision: $precision)
        );       
    }

    #[TestDox("not created from radian can be casted to radian without precision")]
    public function test_create_not_from_radian_cast_to_radian_without_precision(): void
    {
        $sexadecimal = $this->randomSexadecimal();
        $radian = new Number($sexadecimal)->toRadian()->toFloat();
        $angle = Angle::createFromDecimal($sexadecimal);

        // Act & Assert
        $this->assertEquals($radian, $actual = $angle->toRadian(),
            $this->getCastToRadianFailMessage($radian, $actual, $sexadecimal)
        );
    }

    #[TestDox("not created from radian can be casted to radian with a specific precision.")]
    public function test_create_not_from_radian_cast_to_radian_with_precision(): void
    {
        // Arrange
        $precision = $this->positiveRandomInteger(max: PHP_FLOAT_DIG);
        $sexadecimal = $this->randomSexadecimal(precision: $precision);
        $angle = Angle::createFromDecimal($sexadecimal);
        $radian = new Number($sexadecimal)->toRadian()->toFloat($precision);

        // Act & Assert
        $this->assertEquals($radian, $angle->toRadian($precision), $this->getCastError("radian"));
    }

    /**
     * Return a failure message when casting an `Angle` to radian.
     */
    protected function getCastToRadianFailMessage(
        float $expected_radian,
        float $actual_radian,
        float|null $sexadecimal = null,
        int|null $precision = null
    ): string
    {
        if ($sexadecimal === null) {
            if ($precision === null)
                return "$expected_radian radian become $actual_radian radian.";
            else
                return "$expected_radian radian become $actual_radian radian with precision $precision.";
        } else {
            if ($precision === null)
                return "$expected_radian radian is equal to {$sexadecimal}° and become $actual_radian radian.";
            else
                return "$expected_radian radian is equal to {$sexadecimal}° and become $actual_radian radian with precision $precision.";
        }
    }
}