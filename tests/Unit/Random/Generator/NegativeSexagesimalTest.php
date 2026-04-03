<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Generator;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromSexadecimal;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexagesimal as NegativeSexagesimalGenerator;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(NegativeSexagesimalGenerator::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromSexadecimal::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(NegativeSexadecimalValidator::class)]
#[UsesClass(NegativeSexadecimalGenerator::class)]
#[UsesClass(SexadecimalValidator::class)]
#[UsesClass(SexadecimalDegrees::class)]
#[UsesClass(SexagesimalDegrees::class)]
class NegativeSexagesimalTest extends TestCase
{
    public function test_random_generation(): void
    {
        // Arrange
        $generator = new NegativeSexagesimalGenerator(
            self::$faker,
            new NegativeSexadecimalValidator,
            new SexadecimalRange(-Degrees::MAX, 0)
        );

        // Act
        $sexagesimal_values = $generator->generate();

        // Assert
        $this->assertInstanceOf(SexagesimalDegrees::class, $sexagesimal_values);
        $this->assertInstanceOf(Degrees::class, $sexagesimal_values->degrees);
        $this->assertInstanceOf(Minutes::class, $sexagesimal_values->minutes);
        $this->assertInstanceOf(Seconds::class, $sexagesimal_values->seconds);
        $this->assertInstanceOf(Direction::class, $sexagesimal_values->direction);
    }
}