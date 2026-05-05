<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Random\Generator\AngularDistance as AngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveSexadecimal as PositiveSexadecimalGenerator;
use Override;

/**
 * The `AngularDistance` random generator for positive values.
 */
class PositiveAngularDistance extends AngularDistanceGenerator
{
    /**
     * Generate a random value.
     */
    #[Override]
    public function generate(int $precision = PHP_FLOAT_DIG): AngularDistance
    {
        return AngularDistance::createFromDecimal(
            new PositiveSexadecimalGenerator(
                $this->generator, 
                $this->validator, 
                $this->range
            )->generate($precision)
        );
    }
}