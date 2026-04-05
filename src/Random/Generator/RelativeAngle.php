<?php
namespace MarcoConsiglio\Goniometry\Random\Generator;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Random\Generator\Angle as AngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngle as PositiveAngleGenerator;
use MarcoConsiglio\Goniometry\Random\Generator\NegativeAngle as NegativeAngleGenerator;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;

class RelativeAngle extends AngleGenerator
{
    public function generate(int $precision = PHP_FLOAT_DIG): Angle
    {
        $this->validate();

        if ($this->validator->areBothPositive(
            $this->range->start,
            $this->range->end
        )) return new PositiveAngleGenerator(
            $this->generator,
            new PositiveSexadecimalValidator,
            $this->range
        )->generate($precision);

        if ($this->validator->areBothNegative(
            $this->range->start,
            $this->range->end
        )) return new NegativeAngleGenerator(
            $this->generator,
            new NegativeSexadecimalValidator,
            $this->range
        )->generate($precision);

        if ($this->generator->boolean())
            return new PositiveAngleGenerator(
                $this->generator,
                new PositiveSexadecimalValidator,
                new SexadecimalRange(0.0, $this->range->end)
            )->generate($precision);
        else
            return new NegativeAngleGenerator(
                $this->generator,
                new NegativeSexadecimalValidator,
                new SexadecimalRange($this->range->start, NextFloat::beforeZero())
            )->generate($precision);
    }
}