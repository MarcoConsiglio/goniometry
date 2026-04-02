<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(PositiveSexadecimal::class)]
class PositiveSexadecimalTest extends FloatValidatorTestCase
{
    public function test_validate(): void
    {
        /**
         * $min = INF
         * $max = INF
         */
        // Arrange
        $this->setValidator();
        $this->setRange(INF, INF);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * $min = INF
         * 0 ≤ $max < 360
         */
        // Arramge
        $this->setRange(INF, 7);

        // Act & Assert
        $this->testValidator($this->allowedMin(), 7);

        /**
         * 0 ≤ $min < 360
         * $max = INF
         */
        // Arrange
        $this->setRange(30, INF);

        // Act & Assert
        $this->testValidator(30, $this->allowedMax());

        /**
         * $min < 0
         * $max < 0
         */
        // Arrange
        $this->setRange(-1, -1);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * 0 ≤ $min < 360
         * $max < 0
         */
        // Arrange
        $this->setRange(45, -1);

        // Act & Assert
        $this->testValidator(45, $this->allowedMax());

        /**
         * $min < 0
         * 0 ≤ $max < 360
         */
        // Arrange
        $this->setRange(-1, 90);

        // Act & Assert
        $this->testValidator($this->allowedMin(), 90);

        /**
         * $min ≥ 360
         * 0 ≤ $max < 360
         */
        // Arrange
        $this->setRange(361, 90);

        // Act & Assert
        $this->testValidator($this->allowedMin(), 90);

        /**
         * 0 ≤ $min < 360
         * $max ≥ 360
         */
        // Arrange
        $this->setRange(90, 361);

        // Act & Assert
        $this->testValidator(90, $this->allowedMax());

        /**
         * $min ≥ 360
         * $max ≥ 360
         */
        // Arrange
        $this->setRange(361, 361);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());
    }

    protected function setValidator(): void
    {
        $this->validator = new PositiveSexadecimal;
    }

    protected function allowedMin(): float
    {
        return 0.0;
    }

    protected function allowedMax(): float
    {
        return NextFloat::before(Degrees::MAX);
    }
}