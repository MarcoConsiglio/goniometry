<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Validator;

use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Random\Validator\Minutes as MinutesValidator;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestCase("The Minutes validator")]
#[CoversClass(MinutesValidator::class)]
class MinutesTest extends IntegerValidatorTestCase
{
    #[TestDox("validates a MinutesRange.")]
    public function test_validate(): void
    {
        /**
         * $min < 0
         * $max < 0
         */
        // Arrange
        $this->setValidator();
        $this->setRange(-1, -1);
        
        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * $min ≥ 60
         * $max ≥ 60
         */
        // Arrange
        $this->setRange(Minutes::MAX, Minutes::MAX);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * $min < 0
         * $max ≥ 60
         */
        // Arrange
        $this->setRange(-1, Minutes::MAX);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * $min ≥ 60
         * $max < 0
         */
        // Arrange
        $this->setRange(Minutes::MAX, -1);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());
    }

    protected function setValidator(): void
    {
        $this->validator = new MinutesValidator;
    }

    protected function allowedMin(): int
    {
        return 0;
    }

    protected function allowedMax(): int
    {
        return Minutes::MAX - 1;
    }
}