<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use Faker\Generator as FakerGenerator;
use MarcoConsiglio\FakerPhpNumberHelpers\Random\Generator;
use MarcoConsiglio\Goniometry\AngularDistance as AngularDistanceObject;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Random\Validator\AngularDistance as AngularDistanceValidator;

abstract class AngularDistance extends Generator
{
    public function __construct(
        FakerGenerator $generator, 
        AngularDistanceValidator $validator,
        protected AngularDistanceRange $range
    ) {
        return parent::__construct($generator, $validator);
    }

    /**
     * Generate a random value.
     */
    abstract public function generate(int $precision = PHP_FLOAT_DIG): AngularDistanceObject;

    /**
     * Validate the random range.
     * 
     * @codeCoverageIgnore
     */
    protected function validate(): void
    {
        $this->range->validate($this->validator);
    }
}