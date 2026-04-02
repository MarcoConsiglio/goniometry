<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(PositiveSexadecimal::class)]
class PositiveSexadecimalTest extends TestCase
{
    public function test_validate(): void
    {
        /**
         * $min = INF
         * $max = INF
         */
        // Arrange
        $min = INF;
        $max = INF;
        $max_degrees = NextFloat::before(Degrees::MAX);
        $validator = new PositiveSexadecimal;

        // Act
        $validator->validate($min, $max);

        // Assert
        $this->assertSame(0.0, $min);
        $this->assertSame($max_degrees, $max);

        /**
         * $min = INF
         * 0 ≤ $max < 360
         */
        // Arramge
        $min = INF;
        $max = 7;

        // Act
        $validator->validate($min, $max);

        // Assert
        $this->assertSame(0.0, $min);
        $this->assertSame(7.0, $max);

        /**
         * 0 ≤ $min < 360
         * $max = INF
         */
        // Arrange
        $min = 30;
        $max = INF;

        // Act
        $validator->validate($min, $max);

        // Assert
        $this->assertSame(30.0, $min);
        $this->assertSame($max_degrees, $max);

        /**
         * $min < 0
         * $max < 0
         */
        // Arrange
        $min = -1;
        $max = -1;

        // Act
        $validator->validate($min, $max);

        // Assert
        $this->assertSame(0.0, $min);
        $this->assertSame($max_degrees, $max);

        /**
         * 0 ≤ $min < 360
         * $max < 0
         */
        // Arrange
        $min = 45;
        $max = -1;

        // Act
        $validator->validate($min, $max);

        // Assert
        $this->assertSame($min, 45.0);
        $this->assertSame($max_degrees, $max);

        /**
         * $min < 0
         * 0 ≤ $max < 360
         */
        // Arrange
        $min = -1;
        $max = 90;

        // Act
        $validator->validate($min, $max);

        // Assert
        $this->assertSame(0.0, $min);
        $this->assertSame(90.0, $max);

        /**
         * $min ≥ 360
         * 0 ≤ $max < 360
         */
        // Arrange
        $min = 361;
        $max = 90;

        // Act
        $validator->validate($min, $max);

        // Assert
        $this->assertSame(0.0, $min);
        $this->assertSame(90.0, $max);

        /**
         * 0 ≤ $min < 360
         * $max ≥ 360
         */
        // Arrange
        $min = 90;
        $max = 361;

        // Act
        $validator->validate($min, $max);

        // Assert
        $this->assertSame(90.0, $min);
        $this->assertSame($max_degrees, $max);

        /**
         * $min ≥ 360
         * $max ≥ 360
         */
        // Arrange
        $min = 361;
        $max = 361;

        // Act
        $validator->validate($min, $max);

        // Assert
        $this->assertSame(0.0, $min);
        $this->assertSame($max_degrees, $max);
    }
}