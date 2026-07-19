<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use MarcoConsiglio\Goniometry\RadianAngle;
use MarcoConsiglio\Goniometry\Random\Generator\Radian as RadianGenerator;

/**
 * The `RadianAngle` random generator for positive radian values.
 * 
 * @internal
 */
class PositiveRadian extends RadianGenerator
{
    /**
     * Generate a random value.
     */
    public function generate(int $precision = PHP_FLOAT_DIG): RadianAngle
    {
        $this->validate();
        $radian = $this->generator->randomFloat(
            $this->normalizePrecision($precision),
            $this->range->start,
            $this->range->end
        );
        return new RadianAngle($radian);
    }
}