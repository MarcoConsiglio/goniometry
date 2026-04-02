<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use MarcoConsiglio\FakerPhpNumberHelpers\Random\Float\Generator;

class NegativeSexadecimal extends Generator
{
    public function generate(int $precision = PHP_FLOAT_DIG): float
    {
        $this->validate();
        return -$this->generator->randomFloat(
            $this->normalizePrecision($precision),
            abs($this->range->end),
            abs($this->range->start)
        );
    }

    protected function validate(): void
    {
        $this->range->validate($this->validator);
    }
}