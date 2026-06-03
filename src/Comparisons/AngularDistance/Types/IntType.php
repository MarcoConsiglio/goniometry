<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types;

use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\IntType as AngleIntType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\DifferentInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualInt;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Interfaces\Angle;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use Override;

class IntType extends AngleIntType
{
    #[Override]
    public function getStrategyFor(Comparison $comparison, Angle $alfa): Strategy
    {
        if ($comparison instanceof Equal) return new EqualInt($alfa, $this->beta);
        if ($comparison instanceof Different) return new DifferentInt($alfa, $this->beta);
    }
}