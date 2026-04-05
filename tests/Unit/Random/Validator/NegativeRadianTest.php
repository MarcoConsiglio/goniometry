<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeRadian;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(NegativeRadian::class)]
#[UsesClass(RadianRange::class)]
class NegativeRadianTest extends FloatValidatorTestCase
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
         * $min ≥ 0
         * $max ≥ 0
         */
        // Arrange
        $this->setRange(0, 0);
        
        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());
        
        /**
         * $min ≤ -2π
         * $max ≤ -2π
         */
        // Arrange
        $this->setRange(-Radian::MAX - 1, -Radian::MAX - 1);

        // Act & Assert
        $this->testValidator($this->allowedMin(), $this->allowedMax());

        /**
         * -2π < $min < 0
         * $max ≤ -2π 
         */
        // Arrange
        $this->setRange(-3.141593, -Radian::MAX - 1);

        // Act & Assert
        $this->testValidator(-3.141593, $this->allowedMax());

        /**
         * $min ≤ -2π 
         * -2π < $max < 0
         */
        // Arrange
        $this->setRange(-Radian::MAX - 1, -3.141593);

        // Act & Assert
        $this->testValidator($this->allowedMin(), -3.141593);

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
         * -2π < $max < 0
         */
        // Arrange
        $this->setRange(1, -3.141593);

        // Act & Assert
        $this->testValidator($this->allowedMin(), -3.141593);

        /**
         * -2π < $min < 0
         * $max ≥ 0
         */
        // Arrange
        $this->setRange(-3.141593, 1);

        // Act & Assert
        $this->testValidator(-3.141593, $this->allowedMax());
    }

    protected function setValidator(): void
    {
        $this->validator = new NegativeRadian;
    }

    protected function allowedMin(): float
    {
        return RadianRange::min();
    }

    protected function allowedMax(): float
    {
        return NextFloat::beforeZero();
    }
}