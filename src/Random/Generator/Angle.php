<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use Faker\Generator as FakerGenerator;
use MarcoConsiglio\FakerPhpNumberHelpers\Random\Generator;
use MarcoConsiglio\Goniometry\Angle as AngleObject;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;

/**
 * An `Angle` random generator.
 */
abstract class Angle extends Generator
{
    /**
     * Construct an `Angle` random generator.
     */
    public function __construct(
        FakerGenerator $generator, 
        SexadecimalValidator $validator,
        protected SexadecimalRange $range
    ) {
        return parent::__construct($generator, $validator);
    }

    /**
     * Generate a random value.
     */
    abstract public function generate(int $precision = PHP_FLOAT_DIG): AngleObject;

    /**
     * Validate the random range.
     */
    protected function validate(): void
    {
        $this->range->validate($this->validator);
    }
}