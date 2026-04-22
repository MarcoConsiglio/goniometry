<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Fuzzy\Types;

use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\Fuzzy\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Types\AngleType as BaseAngleType;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use Override;

/**
 * The beta angle `InputType` in a fuzzy comparison between alfa and beta angle when
 * beta is an `Angle`.
 */
class AngleType extends BaseAngleType
{
    protected Angle $delta;

    /**
     * Get the correct strategy for the current $comparison operation.
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