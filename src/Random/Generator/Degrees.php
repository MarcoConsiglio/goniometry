<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use Faker\Generator as FakerGenerator;
use MarcoConsiglio\FakerPhpNumberHelpers\Random\Integer\Generator;
use MarcoConsiglio\FakerPhpNumberHelpers\Validation\Validator;
use MarcoConsiglio\Goniometry\Random\DegreesRange;

class Degrees extends Generator
{
    public function __construct(
        FakerGenerator $generator, 
        Validator $validator, 
        DegreesRange $range
    ) {
        return parent::__construct($generator, $validator, $range);
    }

    public function generate(): int
    {
        $this->validate();
        return $this->generator->numberBetween($this->range->start, $this->range->end);
    }

    protected function validate(): void
    {
        $this->range->validate($this->validator);
    }
}