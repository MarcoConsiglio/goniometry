<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use MarcoConsiglio\Goniometry\RadianAngle;
use MarcoConsiglio\Goniometry\Random\Generator\Radian as RadianGenerator;

/**
 * The `RadianAngle` random generator for negative radian values.
 * 
 * @internal
 */
class NegativeRadian extends RadianGenerator
{
    /**
     * Generate a random value.
     */
    public function generate(int $precision = PHP_FLOAT_DIG): RadianAngle
    {
        $this->validate();
        $radian = -$this->generator->randomFloat(
            $this->normalizePrecision($precision),
            abs($this->range->end),
            abs($this->range->start)
        );
        return new RadianAngle($radian);
    }
}