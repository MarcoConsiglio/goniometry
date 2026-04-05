<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Validator;

use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveRadian;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(PositiveRadian::class)]
#[UsesClass(RadianRange::class)]
class PositiveRadianTest extends FloatValidatorTestCase
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
         * $min < 0
         * $max < 0
         */
        // Arrange
        $this->setRange(-1, -1);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * $min < 0
         * 0 ≤ $max < π
         */
        // Arrange
        $this->setRange(-1, RadianRange::max());

        // Act & Assert
        $this->testValidator($this->allowedMin(), RadianRange::max());

        /**
         * 0 ≤ $min < π
         * $max < 0
         */
        // Arrange
        $this->setRange($this->allowedMin(), -1);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * $min ≥ π
         * $max ≥ π
         */
        // Arrange
        $this->setRange(Radian::MAX + 1, Radian::MAX + 1);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * 0 ≤ $min < π
         * $max ≥ π
         */
        // Arrange
        $this->setRange($this->allowedMin(), Radian::MAX + 1);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * $min ≥ π
         * 0 ≤ $max < π
         */
        // Arrange
        $this->setRange(Radian::MAX + 1, $this->allowedMax());

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * 0 ≤ $min < π
         * 0 ≤ $max < π
         */
        $this->setRange(1.570796, 3.141593);

        // Act & Assert
        $this->testValidator(1.570796, 3.141593);
    }

    protected function setValidator(): void
    {
        $this->validator = new PositiveRadian;
    }

    protected function allowedMin(): float
    {
        return 0.0;
    }

    protected function allowedMax(): float
    {
        return RadianRange::max();
    }
}