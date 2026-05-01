<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Generator;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Builders\AngularDistance\FromSexadecimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngularDistance as NegativeAngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeAngularDistance as NegativeAngularDistanceValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(NegativeAngularDistanceGenerator::class)]
#[UsesClass(AngularDistance::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexadecimalAngularDistance::class)]
#[UsesClass(SexagesimalDegrees::class)]
class NegativeAngularDistanceTest extends TestCase
{
    public function test_random_generation(): void
    {
        // Arrange
        $validator = $this->createMock(NegativeAngularDistanceValidator::class);
        $validator->expects($this->once())->method('validate');
        $generator = new NegativeAngularDistanceGenerator(
            self::$faker,
            $validator,
            new AngularDistanceRange(
                SexadecimalAngularDistance::MIN, 
                SexadecimalAngularDistance::MAX
            )
        );

        // Act & Assert
        $this->assertInstanceOf(AngularDistance::class, $generator->generate());
    }
}