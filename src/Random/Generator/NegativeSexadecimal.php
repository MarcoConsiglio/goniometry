<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use MarcoConsiglio\FakerPhpNumberHelpers\Random\Float\Generator;

/**
 * The `Sexadecimal` random generator for negative sexadecimal values.
 */
class NegativeSexadecimal extends Generator
{
    /**
     * Generate a random value.
     */
    public function generate(int $precision = PHP_FLOAT_DIG): float
    {
        $this->validate();
        return -$this->generator->randomFloat(
            $this->normalizePrecision($precision),
            abs($this->range->end),
            abs($this->range->start)
        );
    }

    /**
     * Validate the random range.
     */
    protected function validate(): void
    {
        $this->range->validate($this->validator);
    }
}