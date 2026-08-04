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
     * Construct the `InputType`.
     * 
     * @param AngularDistance $beta The right operand of the comparison.
     * @param Angle $delta The delta error.
     */
    public function __construct(AngularDistance $beta, protected Angle $delta)
    {
        parent::__construct($beta);
    }

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
        return $this->throwError($comparison); // @codeCoverageIgnore
    }
}