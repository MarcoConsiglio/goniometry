<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Random\Generator\Angle as AngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeSexadecimal as NegativeSexadecimalGenerator;

class NegativeAngle extends AngleGenerator
{
    public function generate(int $precision = PHP_FLOAT_DIG): Angle
    {
        $sexadecimal_generator = new NegativeSexadecimalGenerator(
            $this->generator,
            $this->validator,
            $this->range
        );
        return Angle::createFromDecimal(
            $sexadecimal_generator->generate($precision)
        );
    }
}