<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Random\Generator\Sexagesimal as SexagesimalGenerator;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;

class NegativeSexagesimal extends SexagesimalGenerator
{
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