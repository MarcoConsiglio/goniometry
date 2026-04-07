<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Casting\Radian;

use MarcoConsiglio\Goniometry\Casting\Radian\Round;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeRadian as NegativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveRadian as PositiveRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Radian as RadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeRadian as RelativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeRadian as RelativeRadianValidator;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[TestDox("The Radian\Round class")]
#[CoversClass(Round::class)]
#[UsesClass(Radian::class)]
#[UsesTrait(WithAngleFaker::class)]
#[UsesClass(NegativeRadianGenerator::class)]
#[UsesClass(RadianGenerator::class)]
#[UsesClass(RelativeRadianGenerator::class)]
#[UsesClass(RadianRange::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(RelativeRadianValidator::class)]
#[UsesClass(PositiveRadianGenerator::class)]
class RoundTest extends TestCase
{
    #[TestDox("can round an Angle to radian with precision.")]
    public function test_cast_with_precision(): void
    {
        // Arrange
        $precision = $this->randomPrecision();
        $expected = $this->randomRadian();
        $radian = new Radian($expected->value());

        // Act
        $actual = new Round($radian, $precision)->cast();

        // Assert
        $this->assertEquals($expected->value($precision), $actual);
    }

    #[TestDox("can round an Angle to radian without precision.")]
    public function test_cast_without_precision(): void
    {
        // Arrange
        $expected = $this->randomRadian();
        $radian = new Radian($expected->value);

        // Act
        $actual = new Round($radian)->cast();

        // Assert
        $this->assertEquals($expected->value(), $actual);       
    }
}