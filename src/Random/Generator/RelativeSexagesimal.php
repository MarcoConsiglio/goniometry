<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Random\Generator\Sexagesimal as SexagesimalGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeSexadecimal as RelativeSexadecimalGenerator;

/**
 * The `Sexagesimal` random generator for relative sexagesimal values.
 */
class RelativeSexagesimal extends SexagesimalGenerator
{
    public function generate(int $precision = PHP_FLOAT_DIG): SexagesimalDegrees
    {
        $generator = new RelativeSexadecimalGenerator(
            $this->generator,
            $this->validator,
            $this->range
        );
        $sexadecimal_value = $generator->generate($precision);
        $angle = Angle::createFromDecimal($sexadecimal_value);
        return $angle->toSexagesimalDegrees();
    }
}