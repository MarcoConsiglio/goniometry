<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy\Types;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy\Equal;
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
     * Construct the `InputType`.
     * 
     * @param Angle $beta The right operand of the comparison.
     * @param Angle $delta The delta error.
     */
    public function __construct(Angle $beta, protected Angle $delta)
    {
        parent::__construct($beta);
    }

    /**
     * Get the correct strategy for the current $comparison operation.
     * 
     * @param AngularMeasure $alfa The left operand of the `$comparison`.
     */
    #[Override]
    public function getStrategyFor(Comparison $comparison, Angle $alfa): Strategy
    {
        if ($comparison instanceof Equal) return new EqualAngle($alfa, $this->beta, $this->delta);
        return $this->throwError($comparison); // @codeCoverageIgnore
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