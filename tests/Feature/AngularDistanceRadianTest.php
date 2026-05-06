<?php
namespace MarcoConsiglio\Goniometry\Tests\Feature;

use BcMath\Number;
use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\AngularDistanceRadian;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\Generator\FloatGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeRadian as NegativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveRadian as PositiveRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Radian as RadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeRadian as RelativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeRadian as RelativeRadianValidator;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[TestDox("The AngularDistanceRadian")]
#[CoversClass(AngularDistanceRadian::class)]
#[UsesClass(FloatGenerator::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(NegativeRadianGenerator::class)]
#[UsesClass(Radian::class)]
#[UsesClass(RadianGenerator::class)]
#[UsesClass(RelativeRadianGenerator::class)]
#[UsesClass(RelativeRadianValidator::class)]
#[UsesClass(PositiveRadianGenerator::class)]
#[UsesTrait(WithAngleFaker::class)]
class AngularDistanceRadianTest extends TestCase
{
    #[TestDox("can be casted to a radian float value.")]
    public function test_cast_to_float(): void
    {
        // Arrange
        $radian = new AngularDistanceRadian(
            $float = $this->randomRadian(
                min: NextFloat::after(AngularDistanceRadian::MIN),
                max: NextFloat::before(AngularDistanceRadian::MAX)
            )->value()
        );

        // Act & Assert
        $this->assertSame($float, $radian->value());
    }

    #[TestDox("can return the max radian value that is the PI constant.")]
    public function test_max_radian(): void
    {
        // Arrange
        $pi = "3.14159265358979323846264338327950288419716939937510582";

        // Act & Assert
        $this->assertEquals(
            $pi,
            AngularDistanceRadian::getMaxRadian()->value
        );
    }
}