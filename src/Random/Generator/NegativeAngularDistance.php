<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Random\Generator\AngularDistance as AngularDistanceGenerator;
use Override;

/**
 * The `AngularDistance` random generator for negative values.
 * 
 * @internal
 */
class NegativeAngularDistance extends AngularDistanceGenerator
{
    /**
     * Generate a random value.
     */
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