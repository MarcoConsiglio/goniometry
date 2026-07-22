<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy\Types;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\Fuzzy\EqualAngle;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use Override;
/**
 * The beta angle `InputType` in a fuzzy comparison between alfa and beta angle when
 * beta is an `Angle`.
 * 
 * @internal
 */
class AngleType extends InputType
{
    /**
     * The delta error.
     */
    protected Angle $delta;

    /**
     * Get the correct strategy for the current $comparison operation.
     * 
     * @param AngularMeasure $alfa The left operand of the `$comparison`.
     */
    #[Override]
    public function getStrategyFor(Comparison $comparison, Angle $alfa): Strategy
    {
        return new EqualAngle($alfa, $this->beta, $this->delta);
    }

    /**
     * Set the `$delta` error of the fuzzy comparison.
     */
    public function setDelta(Angle $delta): AngleType
    {
        $this->delta = $delta;
        return $this;
    }
}