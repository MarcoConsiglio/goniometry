<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types;

use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\FloatType as AngleFloatType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\DifferentFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterOrEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Interfaces\Angle;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use Override;

class FloatType extends AngleFloatType
{
    #[Override]
    public function getStrategyFor(Comparison $comparison, Angle $alfa): Strategy
    {
        if ($comparison instanceof Equal) return new EqualFloat($alfa, $this->beta, $this->precision);
        if ($comparison instanceof Different) return new DifferentFloat($alfa, $this->beta, $this->precision);
        if ($comparison instanceof Greater) return new GreaterFloat($alfa, $this->beta, $this->precision);
        if ($comparison instanceof GreaterOrEqual) return new GreaterOrEqualFloat($alfa, $this->beta, $this->precision);
    }
}