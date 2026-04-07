<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\Generator\Radian as RadianGenerator;

/**
 * The `Radian` random generator for negative radian values.
 */
class NegativeRadian extends RadianGenerator
{
    /**
     * Generate a random value.
     */
    public function generate(int $precision = PHP_FLOAT_DIG): Radian
    {
        $this->validate();
        $radian = -$this->generator->randomFloat(
            $this->normalizePrecision($precision),
            abs($this->range->end),
            abs($this->range->start)
        );
        return new Radian($radian);
    }
}