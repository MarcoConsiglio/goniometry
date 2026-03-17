<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Enums;

use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(Direction::class)]
#[TestDox("The Direction enum")]
class DirectionTest extends TestCase
{
    #[TestDox("can be counter-clockwise.")]
    public function test_counter_clockwise(): void
    {
        // Arrange
        $direction = Direction::COUNTER_CLOCKWISE;

        // Act & Assert
        $this->assertEquals(1, $direction->value);
    }

    #[TestDox("can be clockwise.")]
    public function test_clockwise(): void
    {
        // Arrange
        $direction = Direction::CLOCKWISE;

        // Act & Assert
        $this->assertEquals(-1, $direction->value);
    }

    #[TestDox("can return the opposite of its value.")]
    public function test_opposite_direction(): void
    {
        // Arrange
        $dir_1 = Direction::COUNTER_CLOCKWISE;
        $dir_2 = Direction::CLOCKWISE;

        // Act & Assert
        $this->assertEquals(Direction::CLOCKWISE, $dir_1->opposite());
        $this->assertEquals(Direction::COUNTER_CLOCKWISE, $dir_2->opposite());
    }
}