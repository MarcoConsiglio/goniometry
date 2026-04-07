<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Validator;

use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeRadian as RelativeRadianValidator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(FloatValidator::class)]
#[UsesClass(RadianRange::class)]
#[UsesClass(RelativeRadianValidator::class)]
class RadianTest extends FloatValidatorTestCase
{
    public function test_avoid_not_allowed_floats(): void
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
         * $max in allowed range
         */
        // Arrange
        $this->setRange(INF, 0.0);

        // Act & Assert
        $this->testValidator($this->allowedMin(), 0.0);

        /**
         * $min in allowed range
         * $max = INF
         */
        // Arrange
        $this->setRange(0.0, INF);

        // Act & Assert
        $this->testValidator(0.0, $this->allowedMax());
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