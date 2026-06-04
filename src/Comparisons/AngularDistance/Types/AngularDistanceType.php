<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\DifferentAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterOrEqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\InputType;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use Override;

class AngularDistanceType extends InputType
{
    /**
     * Construct the `InputType` of $beta.
     * 
     * @param AngularDistance $beta The right operand of the comparison.
     */
    public function __construct(protected AngularDistance $beta) {}

    #[Override]
    public function getStrategyFor(Comparison $comparison, AngularMeasure $alfa): Strategy
    {
        if ($comparison instanceof Equal) return new EqualAngularDistance($alfa, $this->beta);
        if ($comparison instanceof Different) return new DifferentAngularDistance($alfa, $this->beta);
        if ($comparison instanceof Greater) return new GreaterAngularDistance($alfa, $this->beta);
        if ($comparison instanceof GreaterOrEqual) return new GreaterOrEqualAngularDistance($alfa, $this->beta);
    }
}