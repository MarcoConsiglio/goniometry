<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use Faker\Generator as FakerGenerator;
use MarcoConsiglio\FakerPhpNumberHelpers\Random\Generator;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;

/**
 * A `Sexagesimal` random generator.
 */
abstract class Sexagesimal extends Generator
{
    /**
     * Construct a `Sexagesimal` random generator.
     */
    public function __construct(
        FakerGenerator $generator, 
        SexadecimalValidator $validator,
        protected SexadecimalRange $range
    ) {
        return parent::__construct($generator, $validator);
    }

    abstract public function generate(int $precision): SexagesimalDegrees;

    /**
     * Validate the random range.
     * 
     * @codeCoverageIgnore
     */
    protected function validate(): void
    {
        throw new \Exception('Not implemented by design. Do not call this method.');
    }
} 