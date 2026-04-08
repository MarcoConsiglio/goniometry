<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Validator;

use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use MarcoConsiglio\Goniometry\Random\Validator\Degrees as DegreesValidator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestCase("The Degrees validator")]
#[CoversClass(DegreesValidator::class)]
class DegreesTest extends IntegerValidatorTestCase
{
    #[TestDox("validates a DegreesRange.")]
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
        $this->setRange(Degrees::MAX, Degrees::MAX);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * $min < 0
         * $max ≥ 60
         */
        // Arrange
        $this->setRange(-1, Degrees::MAX);
        
        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * $min ≥ 60
         * $max < 0
         */
        // Arrange
        $this->setRange(Degrees::MAX, -1);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());
    }

    protected function allowedMin(): int
    {
        return 0;
    }

    protected function allowedMax(): int
    {
        return Degrees::MAX - 1;
    }

    protected function setValidator(): void
    {
        $this->validator = new DegreesValidator;
    }
}