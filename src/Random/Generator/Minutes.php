<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use Faker\Generator as FakerGenerator;
use MarcoConsiglio\FakerPhpNumberHelpers\Random\Generator;
use MarcoConsiglio\FakerPhpNumberHelpers\Validation\Validator;
use MarcoConsiglio\Goniometry\Minutes as MinutesObject;
use MarcoConsiglio\Goniometry\Random\MinutesRange;

class Minutes extends Generator
{
    public function __construct(
        FakerGenerator $generator, 
        Validator $validator, 
        protected MinutesRange $range
    ) {
        return parent::__construct($generator, $validator);
    }

    public function generate(): MinutesObject
    {
        $this->validate();
        return new MinutesObject($this->generator->numberBetween(
            $this->range->start, $this->range->end
        ));
    }

    protected function validate(): void
    {
        $this->range->validate($this->validator);
    }
}