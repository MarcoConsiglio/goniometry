<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Builders\AngularDistance;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\RadianAngularDistance;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromRadian;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\RadianAngle;
use MarcoConsiglio\Goniometry\Random\Generator\FloatGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeRadian as NegativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveRadian as PositiveRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Radian as RadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeRadian as RelativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeRadian as RelativeRadianValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngle;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(FromRadian::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(FloatGenerator::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(NegativeRadianGenerator::class)]
#[UsesClass(PositiveRadianGenerator::class)]
#[UsesClass(RadianAngle::class)]
#[UsesClass(RadianAngularDistance::class)]
#[UsesClass(RadianGenerator::class)]
#[UsesClass(RelativeRadianGenerator::class)]
#[UsesClass(RelativeRadianValidator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalAngle::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesTrait(WithAngleFaker::class)]
class FromRadianTest extends TestCase
{
    public function test_can_create_an_angle_from_float_value(): void
    {
        // Arrange
        $radian = $this->randomRadian(
            min: NextFloat::after(RadianAngularDistance::MIN),
            max: NextFloat::before(RadianAngularDistance::MAX)
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

    public function test_can_create_an_angle_from_radian_type(): void
    {
        // Arrange
        $radian = new RadianAngularDistance(
            $this->randomRadian(
                min: NextFloat::after(RadianAngularDistance::MIN),
                max: NextFloat::before(RadianAngularDistance::MAX)
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