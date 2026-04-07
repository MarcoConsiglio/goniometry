<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use MarcoConsiglio\FakerPhpNumberHelpers\Random\Float\Generator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;

/**
 * The `Sexadecimal` random generator for relative sexadecimal values.
 */
class RelativeSexadecimal extends Generator
{
    public function generate(int $precision = PHP_FLOAT_DIG): float
    {
        $this->validate();
        if ($this->validator->areBothPositive(
            $this->range->start, 
            $this->range->end
        )) return new PositiveSexadecimal(
            $this->generator,
            $this->validator,
            $this->range
        )->generate($precision);

        if ($this->validator->areBothNegative(
            $this->range->start,
            $this->range->end
        )) return new NegativeSexadecimal(
            $this->generator,
            $this->validator,
            $this->range
        )->generate($precision);

        if ($this->generator->boolean())
            return new PositiveSexadecimal(
                $this->generator,
                new PositiveSexadecimalValidator,
                $this->range
            )->generate($precision);
        else
            return new NegativeSexadecimal(
                $this->generator,
                new NegativeSexadecimalValidator,
                $this->range
            )->generate($precision);
    }

    /**
     * Validate the random range.
     */
    protected function validate(): void
    {
        $this->range->validate($this->validator);
    }
}