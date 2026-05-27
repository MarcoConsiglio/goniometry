<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types;

use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Comparisons\InputType;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use Override;

class AngularDistanceType extends InputType
{
    #[Override]
    public function getStrategyFor(Comparison $comparison, AngularMeasure $alfa): Strategy
    {
        throw new \Exception('Not implemented');
    }
}