<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Casting\Sexadecimal;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal;
use MarcoConsiglio\Goniometry\Casting\Sexadecimal\Round;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngle;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesTrait;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(Round::class)]
#[UsesClass(Angle::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(RelativeSexadecimalValidator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalRange::class)]
#[UsesClass(SexadecimalValidator::class)]
#[UsesTrait(WithAngleFaker::class)]
class RoundTest extends TestCase
{

    public function test_cast_with_precision(): void
    {
        /**
         * Less than PHP_FLOAT_DIG
         */
        // Arrange
        $precision = $this->randomPrecision();
        $sexadecimal = new SexadecimalAngle(
            $this->randomSexadecimal(precision: $precision)
        );
        $expected_float = $sexadecimal->value($precision);

        // Act
        $float = new Round($sexadecimal, $precision)->cast();

        // Assert
        $this->assertSame(
            $expected_float, 
            $float, 
            "$expected_float ≠ $float with $precision precision digits."
        );
    }

    public function test_cast_without_precision(): void
    {
        // Arrange
        $expected_float = $this->randomSexadecimal(precision: 1);
        $sexadecimal = new SexadecimalAngle($expected_float);

        // Act
        $float = new Round($sexadecimal)->cast();

        // Assert
        $this->assertSame(
            $expected_float, 
            $float,
            "$expected_float ≠ $float with no precision."
        );
    }
}