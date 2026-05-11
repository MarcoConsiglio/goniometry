<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Enums;

use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(Rotation::class)]
#[TestDox("The Rotation enum")]
class DirectionTest extends TestCase
{
    #[TestDox("can be counter-clockwise.")]
    public function test_counter_clockwise(): void
    {
        // Arrange
        $direction = Rotation::COUNTER_CLOCKWISE;

        // Act & Assert
        $this->assertEquals(1, $direction->value);
    }

    #[TestDox("can be clockwise.")]
    public function test_clockwise(): void
    {
        // Arrange
        $direction = Rotation::CLOCKWISE;

        // Act & Assert
        $this->assertEquals(-1, $direction->value);
    }

    #[TestDox("can return the opposite of its value.")]
    public function test_opposite_direction(): void
    {
        // Arrange
        $dir_1 = Rotation::COUNTER_CLOCKWISE;
        $dir_2 = Rotation::CLOCKWISE;

        // Act & Assert
        $this->assertEquals(Rotation::CLOCKWISE, $dir_1->opposite());
        $this->assertEquals(Rotation::COUNTER_CLOCKWISE, $dir_2->opposite());
    }
}