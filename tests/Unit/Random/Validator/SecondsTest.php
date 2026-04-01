<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Random\Validator\Seconds as SecondsValidator;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The Seconds validator")]
#[CoversClass(SecondsValidator::class)]
class SecondsTest extends TestCase
{
    #[TestDox("validates a SecondsRange.")]
    public function test_validate(): void
    {
        /**
         * $min < 0
         * $max < 0
         */
        // Arrange
        $min = -1;
        $max = -1;
        $validator = new SecondsValidator;

        // Act
        $validator->validate($min, $max);

        // Assert
        $this->assertSame(0.0, $min);
        $this->assertSame($this->maxSeconds(), $max);

        /**
         * $min < 0
         * $max ≥ 60
         */
        // Arrange
        $min = -1;
        $max = 60;

        // Act
        $validator->validate($min, $max);

        // Assert
        $this->assertSame(0.0, $min);
        $this->assertSame($this->maxSeconds(), $max);

        /**
         * $min ≥ 60
         * $max ≥ 60
         */
        // Arrange
        $min = 60;
        $max = 60;

        // Act
        $validator->validate($min, $max);

        /**
         * $min ≥ 60
         * $max < 0
         */
        // Arrange
        $min = 60;
        $max = -1;

        // Act
        $validator->validate($min, $max);

        // Assert
        $this->assertSame(0.0, $min);
        $this->assertSame($this->maxSeconds(), $max);

        /**
         * $min = INF
         * 0 ≤ $max < 60
         */
        // Arrange
        $min = INF;
        $max = 7;

        // Act
        $validator->validate($min, $max);

        // Assert
        $this->assertSame(0.0, $min);
        $this->assertSame(7.0, $max);

        /**
         * 0 ≤ $min < 60
         * $max = INF
         */
        // Arrange
        $min = 16;
        $max = INF;

        // Act
        $validator->validate($min, $max);

        // Assert
        $this->assertSame(16.0, $min);
        $this->assertSame($this->maxSeconds(), $max);

        /**
         * $min = INF
         * $max = INF
         */
        // Arrange
        $min = INF;
        $max = INF;

        // Act
        $validator->validate($min, $max);

        // Assert
        $this->assertSame(0.0, $min);
        $this->assertSame($this->maxSeconds(), $max);
    }

    protected function maxSeconds(): float
    {
        return NextFloat::before(Seconds::MAX);
    }
}