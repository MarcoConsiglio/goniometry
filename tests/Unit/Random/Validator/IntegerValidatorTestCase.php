<?php
namespace MarcoConsiglio\Goniometry\Tests\Unit\Random\Validator;

use MarcoConsiglio\FakerPhpNumberHelpers\Validation\Integer\Validator as IntegerValidator;
use MarcoConsiglio\Goniometry\Tests\TestCase;

abstract class IntegerValidatorTestCase extends TestCase
{
    protected IntegerValidator $validator;

    protected int $min;

    protected int $max;

    abstract protected function setValidator(): void;

    abstract protected function allowedMin(): int;

    abstract protected function allowedMax(): int;

    protected function testValidator(int $expected_min, int $expected_max): void
    {
        // Act
        $this->validator->validate($this->min, $this->max);

        // Assert
        $this->assertSame($expected_min, $this->min);
        $this->assertSame($expected_max, $this->max);
    }

    protected function setRange(int $min, int $max)
    {
        $this->min = $min;
        $this->max = $max;
    }
}