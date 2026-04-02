<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\Validation\Float\Validator as FloatValidator;
use MarcoConsiglio\Goniometry\Tests\TestCase;

abstract class FloatValidatorTestCase extends TestCase
{
    protected FloatValidator $validator;

    protected float $min;

    protected float $max;

    abstract protected function setValidator(): void;

    abstract protected function allowedMin(): float;

    abstract protected function allowedMax(): float;

    protected function testValidator(float $expected_min, float $expected_max): void
    {
        // Act
        $this->validator->validate($this->min, $this->max);

        // Assert
        $this->assertSame($expected_min, $this->min);
        $this->assertSame($expected_max, $this->max);
    }

    protected function setRange(float $min, float $max)
    {
        $this->min = $min;
        $this->max = $max;
    }
}