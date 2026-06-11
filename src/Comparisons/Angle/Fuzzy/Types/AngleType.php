<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy\Types;

use Error;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\Fuzzy\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\AngleType as BaseAngleType;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use Override;
/**
 * The beta angle `InputType` in a fuzzy comparison between alfa and beta angle when
 * beta is an `Angle`.
 * 
 * @internal
 */
class AngleType extends BaseAngleType
{
    protected Angle $delta;

    /**
     * Get the correct strategy for the current $comparison operation.
     * 
     * @param AngularMeasure $alfa The left operand of the `$comparison`.
     */
    #[Override]
    public function getStrategyFor(Comparison $comparison, AngularMeasure $alfa): Strategy
    {
        if ($comparison instanceof Equal) return new EqualAngle($alfa, $this->beta, $this->delta);
        $unknown_class = get_class($comparison);
        throw new Error("There's no strategy for {$unknown_class} comparison.");
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