<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use Faker\Generator as FakerGenerator;
use MarcoConsiglio\FakerPhpNumberHelpers\Random\Generator;
use MarcoConsiglio\Goniometry\Angle as AngleObject;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;

abstract class Angle extends Generator
{
    public function __construct(
        FakerGenerator $generator, 
        SexadecimalValidator $validator,
        protected SexadecimalRange $range
    ) {
        return parent::__construct($generator, $validator);
    }

    abstract public function generate(int $precision): AngleObject;

    protected function validate(): void
    {
        $this->range->validate($this->validator);
    }
}