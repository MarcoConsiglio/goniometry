<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Casting\Radian;

use MarcoConsiglio\Goniometry\Casting\Radian\Round;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(Round::class)]
#[UsesClass(Radian::class)]
#[UsesClass(WithAngleFaker::class)]
class RoundTest extends TestCase
{
    public function test_cast_with_precision(): void
    {
        // Arrange
        $precision = $this->randomPrecision();
        $expected = $this->randomRadian(precision: $precision);
        $radian = new Radian($expected);

        // Act
        $actual = new Round($radian, $precision)->cast();

        // Assert
        $this->assertEquals($expected, $actual);
    }

    public function test_cast_without_precision(): void
    {
        // Arrange
        $expected = $this->randomRadian();
        $radian = new Radian($expected);

        // Act
        $actual = new Round($radian)->cast();

        // Assert
        $this->assertEquals($expected, $actual);       
    }
}