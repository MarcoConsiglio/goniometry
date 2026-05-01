<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Random\Generator\AngularDistance as AngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngularDistance as NegativeAngularDistanceGenerator;
use Override;

class NegativeAngularDistance extends AngularDistanceGenerator
{
    #[Override]
    public function generate(int $precision = PHP_FLOAT_DIG): AngularDistance
    {
        return AngularDistance::createFromDecimal(
            new NegativeSexadecimal(
                $this->generator,
                $this->validator,
                $this->range
            )->generate($precision)
        );
    }
}