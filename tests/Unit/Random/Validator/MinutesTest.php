<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Validator;

use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Validator\Minutes as MinutesValidator;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestCase("The Minutes validator")]
#[CoversClass(MinutesValidator::class)]
class MinutesTest extends TestCase
{
    #[TestDox("validates a MinutesRange.")]
    public function test_validate(): void
    {
        /**
         * $min < 0
         * $max < 0
         */
        // Arrange
        $min = -1;
        $max = -1;
        $validator = new MinutesValidator;

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
        $min = Minutes::MAX;
        $max = Minutes::MAX;

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
        $max = Minutes::MAX;

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
        $min = Minutes::MAX;
        $max = -1;

        // Act
        $validator->validate($min, $max);

        // Assert
        $this->assertSame(0, $min);
        $this->assertSame($this->maxMinutes(), $max);
    }

    protected function maxMinutes(): int
    {
        return Minutes::MAX - 1;
    }
}