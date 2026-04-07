<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Random\Generator\Radian as RadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeRadian as NegativeRadianGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveRadian as PositiveRadianGenerator;
use MarcoConsiglio\Goniometry\Random\RadianRange;

class RelativeRadian extends RadianGenerator
{
    public function generate(int $precision = PHP_FLOAT_DIG): Radian
    {
        $this->validate();

        if ($this->validator->areBothPositive(
            $this->range->start,
            $this->range->end
        )) return new PositiveRadian(
            $this->generator,
            $this->validator,
            $this->range
        )->generate($precision);

        if ($this->validator->areBothNegative(
            $this->range->start,
            $this->range->end
        )) return new NegativeRadianGenerator(
            $this->generator,
            $this->validator,
            $this->range
        )->generate($precision);

        if ($this->generator->boolean())
            return new PositiveRadianGenerator(
                $this->generator,
                $this->validator,
                new RadianRange(0.0, $this->range->end)
            )->generate($precision);
        else
            return new NegativeRadianGenerator(
                $this->generator,
                $this->validator,
                new RadianRange($this->range->start, NextFloat::beforeZero())
            )->generate($precision);
    }
}