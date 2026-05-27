<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Types;

use MarcoConsiglio\Goniometry\Comparisons\Angle\Different;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Greater;
use MarcoConsiglio\Goniometry\Comparisons\Angle\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Comparison as GeneralComparison;
use MarcoConsiglio\Goniometry\Comparisons\InputType;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

/**
 * The beta `InputType` in a comparison between alfa and beta angles when
 * `$beta` is an `Angle`.
 * 
 * @internal
 */
class AngleType extends InputType
{
    /**
     * Construct the `InputType` of $beta.
     * 
     * @param AngleInterface $beta The right operand of the comparison.
     */
    public function __construct(protected AngleInterface $beta) {}

    /**
     * Get the correct strategy for the current `$comparison` operation.
     * 
     * @param AngleInterface $alfa The left operand of the `$comparison`.
     */
    public function getStrategyFor(GeneralComparison $comparison, AngleInterface $alfa): Strategy
    {
        if ($comparison instanceof Equal) return new EqualAngle($alfa, $this->beta);
        if ($comparison instanceof Different) return new DifferentAngle($alfa, $this->beta);
        if ($comparison instanceof Greater) return new GreaterAngle($alfa, $this->beta);
        if ($comparison instanceof GreaterOrEqual) return new GreaterOrEqualAngle($alfa, $this->beta);
        if ($comparison instanceof Lesser) return new LesserAngle($alfa, $this->beta);
        return new LesserOrEqualAngle($alfa, $this->beta);
    }
}