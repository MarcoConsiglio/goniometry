<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Types;

use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualString;
use MarcoConsiglio\Goniometry\Comparisons\Strategy;

class StringType extends InputType
{
    public function __construct(protected string $beta) {}

    public function getStrategyFor(Comparison $comparison, Angle $alfa): Strategy 
    {
        if ($comparison instanceof Equal) return new EqualString($alfa, $this->beta);
    }
}