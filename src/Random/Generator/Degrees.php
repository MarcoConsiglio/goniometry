<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use Faker\Generator as FakerGenerator;
use MarcoConsiglio\FakerPhpNumberHelpers\Random\Generator;
use MarcoConsiglio\FakerPhpNumberHelpers\Validation\Validator;
use MarcoConsiglio\Goniometry\Degrees as DegreesObject;
use MarcoConsiglio\Goniometry\Random\DegreesRange;

class Degrees extends Generator
{
    public function __construct(
        FakerGenerator $generator, 
        Validator $validator, 
        protected DegreesRange $range
    ) {
        return parent::__construct($generator, $validator);
    }

    public function generate(): DegreesObject
    {
        $this->validate();
        return new DegreesObject(
            $this->generator->numberBetween(
                $this->range->start, 
                $this->range->end
        ));
    }

    protected function validate(): void
    {
        $this->range->validate($this->validator);
    }
}