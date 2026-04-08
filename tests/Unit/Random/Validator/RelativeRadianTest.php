<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Validator;

use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeRadian as RelativeRadianValidator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(RelativeRadianValidator::class)]
#[UsesClass(RadianRange::class)]
class RelativeRadianTest extends FloatValidatorTestCase
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
         * $min ≥ 2π
         * $max ≥ 2π
         */
        // Arrange
        $this->setRange(Radian::MAX, Radian::MAX);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * -2π < $min < 2π
         * $max ≥ 2π
         */
        // Arrange
        $this->setRange(3.141593, Radian::MAX);

        // Act & Assert
        $this->testValidator(3.141593, $this->allowedMax());

        /**
         * $min ≥ 2π
         * -2π < $max < 2π
         */
        // Arrange
        $this->setRange(Radian::MAX, 3.141593);

        // Act & Assert
        $this->testValidator($this->allowedMin(), 3.141593);

        /**
         * $min ≤ -2π
         * $max ≤ -2π
         */
        // Arrange
        $this->setRange(-Radian::MAX, -Radian::MAX);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * $min ≤ -2π
         * -2π < $max < 2π
         */
        // Arrange
        $this->setRange(-Radian::MAX, 3.141593);

        // Act & Assert
        $this->testValidator($this->allowedMin(), 3.141593);

        /**
         * -2π < $min < 2π
         * $max ≤ -2π
         */
        // Arrange
        $this->setRange(-3.141593, -Radian::MAX);

        // Act & Assert
        $this->testValidator(-3.141593, $this->allowedMax());
    }

    protected function setValidator(): void
    {
        $this->validator = new RelativeRadianValidator;
    }

    protected function allowedMin(): float
    {
        return RadianRange::min();
    }

    protected function allowedMax(): float
    {
        return RadianRange::max();
    }
}