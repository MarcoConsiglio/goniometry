<?php
namespace MarcoConsiglio\Goniometry\Tests\Feature;

use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeRadian as NegativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveRadian as PositiveRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Radian as GeneratorRadian;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeRadian as NegativeRadianValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveRadian as PositiveRadianValidator;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[TestDox("The Radian class")]
#[CoversClass(Radian::class)]
#[UsesTrait(WithAngleFaker::class)]
#[UsesClass(PositiveRadianGenerator::class)]
#[UsesClass(GeneratorRadian::class)]
#[UsesClass(RadianRange::class)]
#[UsesClass(PositiveRadianValidator::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(NegativeRadianGenerator::class)]
#[UsesClass(NegativeRadianValidator::class)]
class RadianTest extends TestCase
{
    #[TestDox("can store a positive radian value.")]
    public function test_positive_radian(): void
    {
        // Arrange
        $expected_value = $this->positiveRandomRadian(precision: 1);
        
        // Act
        $radian = new Radian($expected_value->value());

        // Assert
        $this->assertEquals(
            $expected_value->value(),
            $radian->value()
        );
    }

    #[TestDox("can store a negative radian value.")]
    public function test_negative_radian(): void
    {
        // Arrange
        $expected_value = $this->negativeRandomRadian(precision: 6)->value();

        // Act
        $radian = new Radian($expected_value);

        // Assert
        $this->assertEquals(
            $expected_value, 
            $radian->value()   
        );
    }
}