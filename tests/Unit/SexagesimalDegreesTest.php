<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit;

use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Generator\Degrees as DegreesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Minutes as MinutesGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\Seconds as SecondsGenerator;
use MarcoConsiglio\Goniometry\Random\SecondsRange;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Minutes as MinutesValidator;
use MarcoConsiglio\Goniometry\Random\Validator\Seconds as SecondsValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\Attributes\UsesTrait;

#[TestDox("The SexagesimalDegrees class")]
#[CoversClass(SexagesimalDegrees::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(DegreesGenerator::class)]
#[UsesClass(DegreesValidator::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(MinutesGenerator::class)]
#[UsesClass(MinutesGenerator::class)]
#[UsesClass(MinutesValidator::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SecondsGenerator::class)]
#[UsesClass(SecondsGenerator::class)]
#[UsesClass(SecondsRange::class)]
#[UsesClass(SecondsValidator::class)]
#[UsesTrait(WithAngleFaker::class)]
class SexagesimalDegreesTest extends TestCase
{
    protected SexagesimalDegrees $sexagesimal;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->sexagesimal = new SexagesimalDegrees(
            new Degrees($this->randomDegrees()->value()),
            new Minutes($this->randomMinutes()->value()),
            new Seconds($this->randomSeconds(precision: 1)->value()),
            $this->randomDirection()
        );
    }

    #[TestDox("can be casted to a positive angle string.")]
    public function test_positive_angle_cast_to_string(): void
    {
        // Arrange
        $this->sexagesimal->direction = Direction::COUNTER_CLOCKWISE;
        $expected = <<<TEXT
{$this->sexagesimal->degrees} {$this->sexagesimal->minutes} {$this->sexagesimal->seconds}
TEXT;

        // Act & Assert
        $this->assertEquals(
            $expected,
            (string) $this->sexagesimal
        );
    }

    #[TestDox("can be casted to a negative angle string.")]
    public function test_negative_angle_cast_to_string(): void
    {
        // Arrange
        $this->sexagesimal->direction = Direction::CLOCKWISE;
        $sign = '-';
        $expected = <<<TEXT
{$sign}{$this->sexagesimal->degrees} {$this->sexagesimal->minutes} {$this->sexagesimal->seconds}
TEXT;

        // Act & Assert
        $this->assertEquals(
            $expected,
            (string) $this->sexagesimal
        );
    }
}