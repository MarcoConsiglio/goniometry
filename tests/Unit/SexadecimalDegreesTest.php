<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;
use MarcoConsiglio\Goniometry\SexadecimalAngle;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(SexadecimalAngle::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(RelativeSexadecimalValidator::class)]
#[UsesClass(SexadecimalRange::class)]
#[UsesClass(SexadecimalValidator::class)]
#[UsesTrait(WithAngleFaker::class)]
class SexadecimalDegreesTest extends TestCase
{
    public function test_positive_sexadecimal(): void
    {
        // Arrange
        $value = $this->positiveRandomSexadecimal(precision: 1);

        // Act
        $sexadecimal = new SexadecimalAngle($value);

        // Assert
        $this->assertEquals(
            $value, 
            $sexadecimal->value(1)
        );
    }

    public function test_negative_sexadecimal(): void
    {
        // Arrange
        $value = $this->negativeRandomSexadecimal(precision: 1);

        // Act
        $sexadecimal = new SexadecimalAngle($value);

        // Assert
        $this->assertEquals(
            $value,
            $sexadecimal->value(1)
        );       
    }

    public function test_cast_to_string(): void
    {
        // Arrange
        $value = $this->randomSexadecimal();
        $sexadecimal = new SexadecimalAngle($value);
        $expected_value = new Number($value);

        // Act
        $this->assertSame("{$expected_value}°", "$sexadecimal");       
    }
}