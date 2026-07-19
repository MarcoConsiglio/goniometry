<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use Faker\Generator;
use MarcoConsiglio\Goniometry\RadianAngle;
use MarcoConsiglio\Goniometry\Random\RadianRange;
use MarcoConsiglio\Goniometry\Random\Validator\FloatValidator;

/**
 * A `RadianAngle` random generator.
 * 
 * @internal
 */
abstract class Radian extends FloatGenerator
{
    /**
     * Construct a `RadianAngle` random generator.
     */
    public function __construct(
        Generator $generator, 
        FloatValidator $validator,
        protected RadianRange $range
    ) {
        return parent::__construct($generator, $validator);
    }

    abstract public function generate(int $precision = PHP_FLOAT_DIG): RadianAngle;

    /**
     * Validate the random range.
     */
    protected function validate(): void
    {
        $this->range->validate($this->validator);
    }
}