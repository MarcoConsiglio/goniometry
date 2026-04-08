<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use Faker\Generator as FakerGenerator;

use MarcoConsiglio\FakerPhpNumberHelpers\Validation\Validator;
use MarcoConsiglio\Goniometry\Random\SecondsRange;
use MarcoConsiglio\Goniometry\Seconds as SecondsObject;

/**
 * The `Seconds` random generator.
 */
class Seconds extends FloatGenerator
{
    /**
     * Construct the `Degrees` random generator.
     */
    public function __construct(
        FakerGenerator $generator, 
        Validator $validator, 
        protected SecondsRange $range
    ) {
        return parent::__construct($generator, $validator);
    }

    public function generate(int $precision = PHP_FLOAT_DIG): SecondsObject
    {
        $this->validate();
        return new SecondsObject($this->generator->randomFloat(
            $this->normalizePrecision($precision),
            $this->range->start,
            $this->range->end
        ));
    }

    /**
     * Validate the random range.
     */
    protected function validate(): void
    {
        $this->range->validate($this->validator);
    }
}