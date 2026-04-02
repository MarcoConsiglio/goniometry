<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The NegativeSexadecimal validator")]
#[CoversClass(NegativeSexadecimal::class)]
class NegativeSexadecimalTest extends FloatValidatorTestCase
{
    #[TestDox("validates a negative SexadecimalRange.")]
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
         * -360 < $min < 0
         * $max = INF
         */
        // Arrange
        $this->setRange(-90, INF);

        // Act & Assert
        $this->testValidator(-90, $this->allowedMax());

        /**
         * $min = INF
         * -360 < $max < 0
         */
        // Arrange
        $this->setRange(INF, -90);

        // Act & Assert
        $this->testValidator($this->allowedMin(), -90);

        /**
         * $min ≥ 0
         * $max ≥ 0
         */
        // Arrange
        $this->setRange(1, 1);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * $min ≥ 0
         * -360 < $max < 0
         */
        // Arrange
        $this->setRange(1, -90);

        // Act & Assert
        $this->testValidator($this->allowedMin(), -90);

        /**
         * -360 < $min < 0
         * $max ≥ 0
         */
        // Arrange
        $this->setRange(-90, 1);

        // Act & Assert
        $this->testValidator(-90, $this->allowedMax());

        /**
         * $min ≤ -360
         * -360 < $max < 0
         */
        // Arrange
        $this->setRange(-361, -90);

        // Act & Assert
        $this->testValidator($this->allowedMin(), -90);

        /**
         * -360 < $min < 0
         * $max ≤ -360
         */
        // Arrange
        $this->setRange(-90, -361);

        // Act & Assert
        $this->testValidator(-90, $this->allowedMax());

        /**
         * $min ≤ -360
         * $max ≤ -360
         */
        // Arrange
        $this->setRange(-361, -361);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());
    }

    protected function setValidator(): void
    {
        $this->validator = new NegativeSexadecimal;
    }

    protected function allowedMin(): float
    {
        return NextFloat::after(-Degrees::MAX);
    }

    protected function allowedMax(): float
    {
        return NextFloat::beforeZero();
    }
}