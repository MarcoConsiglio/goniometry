<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use Faker\Generator as FakerGenerator;

use MarcoConsiglio\FakerPhpNumberHelpers\Random\Generator;
use MarcoConsiglio\FakerPhpNumberHelpers\Validation\Validator;
use MarcoConsiglio\Goniometry\Random\SecondsRange;
use MarcoConsiglio\Goniometry\Seconds as SecondsObject;

class Seconds extends Generator
{
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