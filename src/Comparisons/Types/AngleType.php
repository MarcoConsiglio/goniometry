<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Types;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\DifferentAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserAngle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserOrEqualAngle;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

/**
 * The beta `InputType` in a comparison between alfa and beta angles when
 * `$beta` is an `Angle`.
 */
class AngleType extends InputType
{
    /**
     * Construct the `InputType` of $beta.
     * 
     * @param Angle $beta The right operand of the comparison.
     */
    public function __construct(protected Angle $beta) {}

    /**
     * Get the correct strategy for the current `$comparison` operation.
     * 
     * @param Angle $alfa The left operand of the `$comparison`.
     */
    public function getStrategyFor(Comparison $comparison, Angle $alfa): Strategy
    {
        if ($comparison instanceof Equal) return new EqualAngle($alfa, $this->beta);
        if ($comparison instanceof Different) return new DifferentAngle($alfa, $this->beta);
        if ($comparison instanceof Greater) return new GreaterAngle($alfa, $this->beta);
        if ($comparison instanceof GreaterOrEqual) return new GreaterOrEqualAngle($alfa, $this->beta);
        if ($comparison instanceof Lesser) return new LesserAngle($alfa, $this->beta);
        return new LesserOrEqualAngle($alfa, $this->beta);
    }
}