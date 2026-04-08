<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The RelativeSexadecimal validator")]
#[CoversClass(RelativeSexadecimalValidator::class)]
class RelativeSexadecimalTest extends FloatValidatorTestCase
{
    #[TestDox("validates a relative SexadecimalRange.")]
    public function test_validate(): void
    {
        /**
         * $min = INF;
         * $max = INF;
         */
        // Arrange
        $this->setValidator();
        $this->setRange(INF, INF);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * $min = INF
         * -360 < $max < 360
         */
        // Arrange
        $this->setRange(INF, 0);

        // Act & Assert
        $this->testValidator($this->allowedMin(), 0);

        /**
         * -360 < $min < 360
         * $max = INF
         */
        // Arrange
        $this->setRange(0, INF);

        // Act & Assert
        $this->testValidator(0, $this->allowedMax());

        /**
         * $min ≥ 360
         * $max ≥ 360
         */
        // Arrange
        $this->setRange(361, 361);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * $min ≥ 360
         * $max ≤ -360
         */
        // Arrange
        $this->setRange(361, -361);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * $min ≤ -360
         * $max ≥ 360
         */
        // Arrange
        $this->setRange(-361, 361);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

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
        $this->validator = new RelativeSexadecimalValidator;
    }

    protected function allowedMin(): float
    {
        return NextFloat::after(-Degrees::MAX);
    }

    protected function allowedMax(): float
    {
        return NextFloat::before(Degrees::MAX);
    }
}