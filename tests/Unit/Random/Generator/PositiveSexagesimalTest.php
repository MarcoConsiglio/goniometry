<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Generator;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexadecimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexagesimal as PositiveSexagesimalGenerator;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The PositiveSexagesimal random generator")]
#[CoversClass(PositiveSexagesimalGenerator::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(PositiveSexadecimalGenerator::class)]
#[UsesClass(SexadecimalRange::class)]
#[UsesClass(PositiveSexadecimalValidator::class)]
#[UsesClass(SexadecimalValidator::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
class PositiveSexagesimalTest extends TestCase
{
    #[TestDox("generates positive random sexagesimal values.")]
    public function test_random_generation(): void
    {
        // Arrange
        $generator = new PositiveSexagesimalGenerator(
            self::$faker,
            new PositiveSexadecimalValidator,
            new SexadecimalRange(0, SexadecimalRange::max())
        );

        // Act
        $sexagesimal_values = $generator->generate();

        // Assert
        $this->assertInstanceOf(SexagesimalDegrees::class, $sexagesimal_values);
    }
}