<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Enums;

use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Rotation::class)]
class DirectionTest extends TestCase
{
    public function test_counter_clockwise(): void
    {
        // Arrange
        $direction = Rotation::COUNTER_CLOCKWISE;

        // Act & Assert
        $this->assertEquals(1, $direction->value);
    }

    public function test_clockwise(): void
    {
        // Arrange
        $direction = Rotation::CLOCKWISE;

        // Act & Assert
        $this->assertEquals(-1, $direction->value);
    }

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