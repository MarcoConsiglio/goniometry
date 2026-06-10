<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types;

use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\StringType as AngleStringType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\DifferentString;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualString;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterOrEqualString;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterString;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserString;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Lesser;
use MarcoConsiglio\Goniometry\Interfaces\Angle;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use Override;

class StringType extends AngleStringType
{
    #[Override]
    public function getStrategyFor(Comparison $comparison, Angle $alfa): Strategy
    {
        if ($comparison instanceof Equal) return new EqualString($alfa, $this->beta);
        if ($comparison instanceof Different) return new DifferentString($alfa, $this->beta);
        if ($comparison instanceof Greater) return new GreaterString($alfa, $this->beta);
        if ($comparison instanceof GreaterOrEqual) return new GreaterOrEqualString($alfa, $this->beta);
        if ($comparison instanceof Lesser) return new LesserString($alfa, $this->beta);
    }
}