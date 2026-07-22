<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy\Types;

use Error;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy\Equal;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\Fuzzy\EqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use Override;

/**
 * The beta `InputType` in a comparison between alfa and beta angular distances when
 * `$beta` is an `AngularDistance`.
 * 
 * @internal
 */
class AngularDistanceType extends InputType
{
    /**
     * The delta error.
     */
    protected Angle $delta;

    /**
     * Get the correct strategy for the current `$comparison` operation.
     * 
     * @param AngularMeasure $alfa The left operand of the `$comparison`.
     * @throws Error if there's no strategy for `$comparison`.
     */
    #[Override]
    public function getStrategyFor(Comparison $comparison, AngularDistance $alfa): Strategy
    {
        if ($comparison instanceof Equal) return new EqualAngularDistance($alfa, $this->beta, $this->delta);
        return $this->throwError($comparison);
    }
}