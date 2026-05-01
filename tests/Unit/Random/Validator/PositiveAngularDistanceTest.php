<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveAngularDistance;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(PositiveAngularDistance::class)]
class PositiveAngularDistanceTest extends FloatValidatorTestCase
{
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
         * $min in range
         * $max < 0
         */
        // Arrange
        $this->setRange(1, -1);

        // Act & Assert
        $this->testValidator(1, $this->allowedMax()); 
        
        /**
         * $min < 0
         * $max in range
         */
        // Arrange
        $this->setRange(-1, 1);

        // Act & Assert
        $this->testValidator($this->allowedMin(), 1);

        /**
         * $min ≥ +180
         * $max ≥ +180
         */
        // Arrange
        $this->setRange(181, 181);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * $min in range
         * $max ≥ +180
         */
        // Arrange
        $this->setRange(1, 181);

        // Act & Assert
        $this->testValidator(1, $this->allowedMax());

        /**
         * $min ≥ +180
         * $max in range
         */
        // Arrange
        $this->setRange(181, 179);

        // Act & Assert
        $this->testValidator($this->allowedMin(), 179);
    }

    #[Override]
    protected function setValidator(): void
    {
        $this->validator = new PositiveAngularDistance;
    }

    #[Override]
    protected function allowedMin(): float
    {
        return 0.0;
    }

    #[Override]
    protected function allowedMax(): float
    {
        return NextFloat::before(SexadecimalAngularDistance::MAX);
    }
}