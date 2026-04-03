<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\Goniometry\Random\Generator\Sexagesimal as SexagesimalGenerator;

class PositiveSexagesimal extends SexagesimalGenerator
{
    public function generate(int $precision = PHP_FLOAT_DIG): SexagesimalDegrees
    {
        $this->validate();
        $sexadecimal_generator = new PositiveSexadecimal(
            $this->generator,
            $this->validator,
            $this->range
        )->generate($precision);
        $angle = Angle::createFromDecimal($sexadecimal_generator);
        return $angle->toSexagesimalDegrees();
    }

    protected function validate(): void
    {
        $this->range->validate($this->validator);
    }
}