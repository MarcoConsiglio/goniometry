<?php
namespace MarcoConsiglio\Goniometry\Tests\Feature;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[TestDox("The SexadecimalAngularDistance")]
#[CoversClass(SexadecimalAngularDistance::class)]
#[UsesClass(AngularDistanceRange::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(RelativeSexadecimalValidator::class)]
#[UsesTrait(WithAngleFaker::class)]
class SexadecimalAngularDistanceTest extends TestCase
{
    protected SexadecimalAngularDistance $sexadecimal;

    protected float $value;
    
    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->sexadecimal = new SexadecimalAngularDistance(
            $this->value = $this->randomSexadecimal(
                min: AngularDistanceRange::min(),
                max: AngularDistanceRange::max(),
                precision: 3
            )
        );
    }

    #[TestDox("stores a sexadecimal value.")]
    public function test_value(): void
    {
        // Act & Assert
        $this->assertEquals(
            $this->value, $this->sexadecimal->value()
        );
    }

    #[TestDox("can be casted to string.")]
    public function test_cast_to_string(): void
    {
        // Act & Assert
        $this->assertEquals(
            "{$this->value}°", "{$this->sexadecimal}"
        );
    }

    #[TestDox("can toggle its rotation direction.")]
    public function test_toggle_direction(): void
    {
        // Arrange
        $sexadecimal = new SexadecimalAngularDistance(
            $this->randomFloat(
                min: AngularDistanceRange::min(),
                max: AngularDistanceRange::max()
            )
        );
        $expected = $sexadecimal->value->opposite();

        // Act & Assert
        $this->assertEquals($expected, $sexadecimal->oppositeRotation()->value);
    }

    #[TestDox("can return its Number instance.")]
    public function test_getParent(): void
    {
        // Arrange
        $sexadecimal = new SexadecimalAngularDistance(
            $value = $this->randomFloat(
                min: AngularDistanceRange::min(),
                max: AngularDistanceRange::max(),
                precision: $precision = 3
            )
        );

        // Act
        $parent = $sexadecimal->getParent();

        // Assert
        $this->assertInstanceOf(Number::class, $parent);
        $this->assertEquals($value, $parent->toFloat($precision));
    }
}