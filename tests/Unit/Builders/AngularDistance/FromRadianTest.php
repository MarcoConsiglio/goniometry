<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders\AngularDistance;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\AngularDistanceRadian;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromRadian;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\Generator\FloatGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeRadian as NegativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveRadian as PositiveRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Radian as RadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeRadian as RelativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeRadian as RelativeRadianValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(FromRadian::class)]
#[UsesClass(AngularDistanceRadian::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Radian::class)]
#[UsesClass(FloatGenerator::class)]
#[UsesClass(NegativeRadianGenerator::class)]
#[UsesClass(RadianGenerator::class)]
#[UsesClass(RelativeRadianGenerator::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(RelativeRadianValidator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesClass(PositiveRadianGenerator::class)]
#[UsesTrait(WithAngleFaker::class)]
class FromRadianTest extends TestCase
{
    #[TestDox("can create an angle from a radian float type value.")]
    public function test_can_create_an_angle_from_float_value(): void
    {
        // Arrange
        $radian = $this->randomRadian(
            min: NextFloat::after(AngularDistanceRadian::MIN),
            max: NextFloat::before(AngularDistanceRadian::MAX)
        )->value();
        $builder = new FromRadian($radian);

        // Act
        $result = $builder->fetchData();

        // Assert
        $this->assertEquals(
            $radian,
            $result[2]->value()
        );
        $this->assertInstanceOf(SexagesimalDegrees::class, $result[0]);
        $this->assertInstanceOf(SexadecimalAngularDistance::class, $result[1]);
    }

    #[TestDox("can create an angle from a Radian type value.")]
    public function test_can_create_an_angle_from_radian_type(): void
    {
        // Arrange
        $radian = new AngularDistanceRadian(
            $this->randomRadian(
                min: NextFloat::after(AngularDistanceRadian::MIN),
                max: NextFloat::before(AngularDistanceRadian::MAX)
            )->value()
        );
        $builder = new FromRadian($radian);

        // Act
        $result = $builder->fetchData();

        // Assert
        $this->assertEquals(
            $radian->value(),
            $result[2]->value()
        );
        $this->assertInstanceOf(SexagesimalDegrees::class, $result[0]);
        $this->assertInstanceOf(SexadecimalAngularDistance::class, $result[1]);
    }
}