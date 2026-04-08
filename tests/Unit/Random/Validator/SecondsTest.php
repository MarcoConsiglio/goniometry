<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Random\SecondsRange;
use MarcoConsiglio\Goniometry\Random\Validator\Seconds as SecondsValidator;
use MarcoConsiglio\Goniometry\Seconds;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The Seconds validator")]
#[CoversClass(SecondsValidator::class)]
#[UsesClass(SecondsRange::class)]
class SecondsTest extends FloatValidatorTestCase
{
    #[TestDox("validates a SecondsRange.")]
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
         * $min < 0
         * $max ≥ 60
         */
        // Arrange
        $this->setRange(-1, Seconds::MAX);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * $min ≥ 60
         * $max ≥ 60
         */
        // Arrange
        $this->setRange(Seconds::MAX, Seconds::MAX);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * $min ≥ 60
         * $max < 0
         */
        // Arrange
        $this->setRange(Seconds::MAX, -1);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * $min = INF
         * 0 ≤ $max < 60
         */
        // Arrange
        $this->setRange(INF, 7);

        // Act & Assert
        $this->testValidator($this->allowedMin(), 7);

        /**
         * 0 ≤ $min < 60
         * $max = INF
         */
        // Arrange
        $this->setRange(16, INF);

        // Act & Assert
        $this->testValidator(16, $this->allowedMax());

        /**
         * $min = INF
         * $max = INF
         */
        // Arrange
        $this->setRange(INF, INF);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());
    }

    protected function setValidator(): void
    {
        $this->validator = new SecondsValidator;
    }

    protected function allowedMin(): float
    {
        return 0.0;
    }

    protected function allowedMax(): float
    {
        return NextFloat::before(Seconds::MAX);
    }
}