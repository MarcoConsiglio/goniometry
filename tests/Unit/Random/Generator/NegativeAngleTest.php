<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Generator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngle as NegativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The NegativeAngle random generator")]
#[CoversClass(NegativeAngleGenerator::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(SexadecimalRange::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
class NegativeAngleTest extends TestCase
{
    #[TestDox("generates a negative random Angle object.")]
    public function test_random_generation(): void
    {
        // Arrange
        $validator = $this->createMock(NegativeSexadecimalValidator::class);
        $validator->expects($this->once())->method("validate");
        $generator = new NegativeAngleGenerator(
            self::$faker,
            $validator,
            new SexadecimalRange(
                SexadecimalRange::min(),
                NextFloat::beforeZero()
            )
        );

        // Act
        $angle = $generator->generate();

        // Assert
        $this->assertInstanceOf(Angle::class, $angle);
        $this->assertSame(Direction::CLOCKWISE, $angle->direction);
    }
}