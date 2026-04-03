<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use Faker\Generator as FakerGenerator;
use MarcoConsiglio\FakerPhpNumberHelpers\Random\Generator;
use MarcoConsiglio\FakerPhpNumberHelpers\Validation\Validator;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;

abstract class Sexagesimal extends Generator
{
    public function __construct(
        FakerGenerator $generator, 
        Validator $validator,
        protected SexadecimalRange $range
    ) {
        return parent::__construct($generator, $validator);
    }

    abstract public function generate(int $precision): SexagesimalDegrees;
} 