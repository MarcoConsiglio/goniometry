<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Generator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngularDistance as RelativeAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeAngularDistance as RelativeAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(RelativeAngularDistanceGenerator::class)]
#[UsesClass(AngularDistance::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(RelativeSexadecimalGenerator::class)]
#[UsesClass(FloatValidator::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexagesimalDegrees::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
class RelativeAngularDistanceTest extends TestCase
{
    public function test_random_generation(): void
    {
        // Arrange
        $validator = $this->createMock(RelativeAngularDistanceValidator::class);
        $validator->expects($this->once())->method('validate');
        $generator = new RelativeAngularDistanceGenerator(
            self::$faker,
            $validator,
            new AngularDistanceRange(
                NextFloat::after(SexadecimalAngularDistance::MIN),
                NextFloat::after(SexadecimalAngularDistance::MAX)
            )
        );

        // Act & Assert
        $this->assertInstanceOf(AngularDistance::class, $generator->generate());
    }
}