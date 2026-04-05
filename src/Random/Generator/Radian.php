<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use Faker\Generator;
use MarcoConsiglio\FakerPhpNumberHelpers\Random\Generator as RandomGenerator;
use MarcoConsiglio\Goniometry\Radian as RadianObject;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\Validator\Radian as RadianValidator;

abstract class Radian extends RandomGenerator
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

    /**
     * Limit the `$precision` between `0` and `PHP_FLOAT_DIG`.
     */
    protected function normalizePrecision(int $precision): int
    {
        $precision = abs($precision);
        if ($precision > PHP_FLOAT_DIG) $precision = PHP_FLOAT_DIG;
        return $precision;       
    }
}