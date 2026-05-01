<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeAngularDistance;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(NegativeAngularDistance::class)]
class NegativeAngularDistanceTest extends FloatValidatorTestCase
{
    public function test_validate(): void
    {
        /**
         * $min ≥ 0
         * $max ≥ 0
         */
        // Arrange
        $this->setValidator();
        $this->setRange(0, 0);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * $min ≥ 0
         * $max in range
         */
        // Arrange
        $this->setRange(0, -1);

        // Act & Assert
        $this->testValidator($this->allowedMin(), -1);

        /**
         * $min in range
         * $max ≥ 0
         */
        // Arrange
        $this->setRange(-179, 0);

        // Act & Assert
        $this->testValidator(-179, $this->allowedMax());

        /**
         * $min ≤ -180
         * $max ≤ -180
         */
        // Arrange
        $this->setRange(-180, -180);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * $min in range
         * $max ≤ -180
         */
        // Arrange
        $this->setRange(-179, -180);

        // Act & Assert
        $this->testValidator(-179, $this->allowedMax());

        /**
         * $min ≤ -180
         * $max in range
         */
        // Arrange
        $this->setRange(-180, -1);

        // Act & Assert
        $this->testValidator($this->allowedMin(), -1);

    }

    #[Override]
    protected function setValidator(): void
    {
        $this->validator = new NegativeAngularDistance;
    }

    #[Override]
    protected function allowedMin(): float
    {
        return NextFloat::after(SexadecimalAngularDistance::MIN);
    }

    #[Override]
    protected function allowedMax(): float
    {
        return NextFloat::beforeZero();
    }
}