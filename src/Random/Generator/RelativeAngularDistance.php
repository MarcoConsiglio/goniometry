<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Random\Generator\AngularDistance as AngularDistanceGenerator;
use Override;

/**
 * The `AngularDistance` random generator for relative values.
 */
class RelativeAngularDistance extends AngularDistanceGenerator
{
    /**
     * Generate a random value.
     */
    #[Override]
    public function generate(int $precision = PHP_FLOAT_DIG): AngularDistance
    {
        return AngularDistance::createFromDecimal(
            new RelativeSexadecimal(
                $this->generator,
                $this->validator,
                $this->range
            )->generate($precision)
        );
    }
}