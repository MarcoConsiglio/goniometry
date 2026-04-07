<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use Faker\Generator;
use MarcoConsiglio\FakerPhpNumberHelpers\Random\Generator as RandomGenerator;
use MarcoConsiglio\Goniometry\Radian as RadianObject;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\Validator\Radian as RadianValidator;

abstract class Radian extends FloatGenerator
{
    public function __construct(
        Generator $generator, 
        RadianValidator $validator,
        protected RadianRange $range
    ) {
        return parent::__construct($generator, $validator);
    }

    abstract public function generate(int $precision = PHP_FLOAT_DIG): RadianObject;

    protected function validate(): void
    {
        $this->range->validate($this->validator);
    }
}