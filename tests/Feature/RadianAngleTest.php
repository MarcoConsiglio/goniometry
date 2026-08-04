<?php
namespace MarcoConsiglio\Goniometry\Tests\Feature;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\RadianAngle;
use MarcoConsiglio\Goniometry\Random\Generator\FloatGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeRadian as NegativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveRadian as PositiveRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Radian as RadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeRadian as RelativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeRadian as NegativeRadianValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveRadian as PositiveRadianValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeRadian as RelativeRadianValidator;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[TestDox("The RadianAngle")]
#[CoversClass(RadianAngle::class)]
#[UsesClass(FloatGenerator::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(NegativeRadianGenerator::class)]
#[UsesClass(NegativeRadianValidator::class)]
#[UsesClass(PositiveRadianGenerator::class)]
#[UsesClass(PositiveRadianValidator::class)]
#[UsesClass(RadianGenerator::class)]
#[UsesClass(RadianRange::class)]
#[UsesClass(RelativeRadianGenerator::class)]
#[UsesClass(RelativeRadianValidator::class)]
#[UsesTrait(WithAngleFaker::class)]
class RadianAngleTest extends TestCase
{
    #[TestDox("can store a positive radian value.")]
    public function test_positive_radian(): void
    {
        // Arrange
        $expected_value = $this->positiveRandomRadian(precision: 1);
        
        // Act
        $radian = new RadianAngle($expected_value->value());

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
        $radian = new RadianAngle($expected_value);

        // Assert
        $this->assertEquals(
            $expected_value, 
            $radian->value()   
        );
    }

    public function test_cast_to_float(): void
    {
        // Arrange
        $radian = new RadianAngle(
            $float = $this->randomRadian(
                min: NextFloat::after(RadianAngle::MIN),
                max: NextFloat::before(RadianAngle::MAX)
            )->value()
        );

        // Act & Assert
        $this->assertSame($float, $radian->value());
    }

    public function test_max_radian(): void
    {
        // Arrange
        $double_pi = new Number("3.14159265358979323846264338327950288419716939937510582")->mul(2);

        // Act & Assert
        $this->assertTrue(
            $double_pi->isEqual(
                RadianAngle::getMaxRadian()
            )
        );
    }
}