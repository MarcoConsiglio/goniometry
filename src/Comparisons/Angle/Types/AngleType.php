<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Types;

use Error;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Different;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Greater;
use MarcoConsiglio\Goniometry\Comparisons\Angle\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\Angle\LesserOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualAngle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\InputType;
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
     * @param Angle $beta The right operand of the comparison.
     */
    public function __construct(protected Angle $beta) {}

    /**
     * Get the correct strategy for the current `$comparison` operation.
     * 
     * @param Angle $alfa The left operand of the `$comparison`.
     * @throws Error if there's no strategy for `$comparison`.
     */
    public function getStrategyFor(Comparison $comparison, Angle $alfa): Strategy
    {
        if ($comparison instanceof Equal) return new EqualAngle($alfa, $this->beta);
        if ($comparison instanceof Different) return new DifferentAngle($alfa, $this->beta);
        if ($comparison instanceof Greater) return new GreaterAngle($alfa, $this->beta);
        if ($comparison instanceof GreaterOrEqual) return new GreaterOrEqualAngle($alfa, $this->beta);
        if ($comparison instanceof Lesser) return new LesserAngle($alfa, $this->beta);
        if ($comparison instanceof LesserOrEqual) return new LesserOrEqualAngle($alfa, $this->beta);
        return $this->throwError($comparison);
    }
}