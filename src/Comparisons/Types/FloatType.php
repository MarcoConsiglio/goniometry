<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Types;

use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\Strategy;

class FloatType extends InputType
{
    public function __construct(protected float $beta, protected int $precision) {}

    public function getStrategyFor(Comparison $comparison, Angle $alfa): Strategy
    {
        if ($comparison instanceof Equal) return new EqualFloat($alfa, $this->beta, $this->precision);
    }
}