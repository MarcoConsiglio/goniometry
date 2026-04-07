<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Random\Generator\Sexagesimal as SexagesimalGenerator;

/**
 * The `Sexagesimal` random generator for positive sexagesimal values.
 */
class PositiveSexagesimal extends SexagesimalGenerator
{
    /**
     * Generate a random value.
     */
    public function generate(int $precision = PHP_FLOAT_DIG): SexagesimalDegrees
    {
        $sexadecimal_generator = new PositiveSexadecimal(
            $this->generator,
            $this->validator,
            $this->range
        )->generate($precision);
        $angle = Angle::createFromDecimal($sexadecimal_generator);
        return $angle->toSexagesimalDegrees();
    }
}