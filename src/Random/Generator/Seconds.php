<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use Faker\Generator as FakerGenerator;
use MarcoConsiglio\FakerPhpNumberHelpers\FloatRange;
use MarcoConsiglio\FakerPhpNumberHelpers\Random\Float\Generator;
use MarcoConsiglio\FakerPhpNumberHelpers\Validation\Validator;
use MarcoConsiglio\Goniometry\Random\SecondsRange;

class Seconds extends Generator
{
    public function __construct(
        FakerGenerator $generator, 
        Validator $validator, 
        SecondsRange $range
    ) {
        return parent::__construct($generator, $validator, $range);
    }

    public function generate(int $precision = PHP_FLOAT_DIG): float
    {
        $this->validate();
        return $this->generator->randomFloat(
            $this->normalizePrecision($precision),
            $this->range->start,
            $this->range->end
        );
    }

    protected function validate(): void
    {
        $this->range->validate($this->validator);
    }
}