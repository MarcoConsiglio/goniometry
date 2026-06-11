<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy\Types;

use Error;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy\Types\AngleType as FuzzyAngleType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy\Equal;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\Fuzzy\EqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use Override;

class AngularDistanceType extends FuzzyAngleType
{
    protected Angle $delta;

    #[Override]
    public function getStrategyFor(Comparison $comparison, AngularMeasure $alfa): Strategy
    {
        if ($comparison instanceof Equal) return new EqualAngularDistance($alfa, $this->beta, $this->delta);
        $unknown_class = get_class($comparison);
        throw new Error("There's no strategy for {$unknown_class} comparison.");
    }
}