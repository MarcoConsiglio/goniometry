<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit;

use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The SexagesimalDegrees class")]
#[CoversClass(SexagesimalDegrees::class)]
#[UsesClass(Degrees::class)]
#[UsesClass(Minutes::class)]
#[UsesClass(Seconds::class)]
#[UsesClass(SexagesimalDegrees::class)]
class SexagesimalDegreesTest extends TestCase
{
    protected SexagesimalDegrees $sexagesimal;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->sexagesimal = new SexagesimalDegrees(
            new Degrees($this->randomDegrees()),
            new Minutes($this->randomMinutes()),
            new Seconds($this->randomSeconds()),
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