<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Validator;

use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestCase("The Degrees validator")]
#[CoversClass(DegreesValidator::class)]
class DegreesTest extends TestCase
{
    #[TestDox("validates a DegreesRange.")]
    public function test_validate(): void
    {
        /**
         * $min < 0
         * $max < 0
         */
        // Arrange
        $min = -1;
        $max = -1;
        $validator = new DegreesValidator;

        // Act
        $validator->validate($min, $max);

        // Assert
        $this->assertSame(0, $min);
        $this->assertSame($this->maxMinutes(), $max);

        /**
         * $min ≥ 60
         * $max ≥ 60
         */
        // Arrange
        $min = Degrees::MAX;
        $max = Degrees::MAX;

        // Act
        $validator->validate($min, $max);

        // Assert
        $this->assertSame(0, $min);
        $this->assertSame($this->maxMinutes(), $max);

        /**
         * $min < 0
         * $max ≥ 60
         */
        // Arrange
        $min = -1;
        $max = Degrees::MAX;

        // Act
        $validator->validate($min, $max);

        // Assert
        $this->assertSame(0, $min);
        $this->assertSame($this->maxMinutes(), $max);

        /**
         * $min ≥ 60
         * $max < 0
         */
        // Arrange
        $min = Degrees::MAX;
        $max = -1;

        // Act
        $validator->validate($min, $max);

        // Assert
        $this->assertSame(0, $min);
        $this->assertSame($this->maxMinutes(), $max);
    }

    protected function maxMinutes(): int
    {
        return Degrees::MAX - 1;
    }
}