<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use Faker\Generator as FakerGenerator;
use MarcoConsiglio\FakerPhpNumberHelpers\Random\Generator;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;

abstract class Sexagesimal extends Generator
{
    public function __construct(
        FakerGenerator $generator, 
        SexadecimalValidator $validator,
        protected SexadecimalRange $range
    ) {
        return parent::__construct($generator, $validator);
    }

    abstract public function generate(int $precision): SexagesimalDegrees;

    protected function validate(): void
    {
        $this->range->validate($this->validator);
    }
} 