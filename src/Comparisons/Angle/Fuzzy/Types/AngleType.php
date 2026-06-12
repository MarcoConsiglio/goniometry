<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy\Types;

use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\Fuzzy\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\AngleType as BaseAngleType;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use Override;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;
/**
 * The beta angle `InputType` in a fuzzy comparison between alfa and beta angle when
 * beta is an `Angle`.
 * 
 * @internal
 */
class AngleType extends BaseAngleType
{
    protected AngleInterface $delta;

    /**
     * Get the correct strategy for the current $comparison operation.
     * 
     * @param AngleInterface $alfa The left operand of the `$comparison`.
     */
    #[Override]
    public function getStrategyFor(Comparison $comparison, AngleInterface $alfa): Strategy
    {
        return new EqualAngle($alfa, $this->beta, $this->delta);
    }

    /**
     * Set the `$delta` error of the fuzzy comparison.
     */
    public function setDelta(AngleInterface $delta): AngleType
    {
        $this->delta = $delta;
        return $this;
    }
}