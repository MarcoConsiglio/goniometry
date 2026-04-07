<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Random\Generator\Sexagesimal as SexagesimalGenerator;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;

/**
 * The `Sexagesimal` random generator for negative sexagesimal values.
 */
class NegativeSexagesimal extends SexagesimalGenerator
{
    /**
     * Generate a random value.
     */
    public function generate(int $precision = PHP_FLOAT_DIG): SexagesimalDegrees
    {
        $sexadecimal_generator = new NegativeSexadecimal(
            $this->generator,
            $this->validator,
            $this->range
        );
        $angle = Angle::createFromDecimal(
            $sexadecimal_generator->generate($precision)
        );
        return $angle->toSexagesimalDegrees();
    }
}