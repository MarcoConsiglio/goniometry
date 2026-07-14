<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Types;

use Error;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentString;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualString;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualString;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterString;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualString;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserString;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\InputType;
use MarcoConsiglio\Goniometry\Comparisons\LesserOrEqual;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;

/**
 * The beta `InputType` in a comparison between alfa and beta angles when
 * `$beta` is a `string`.
 * 
 * @internal
 */
class StringType extends InputType
{
    /**
     * Construct the `InputType` of `$beta`.
     * 
     * @param string $beta The right operand of the comparison.
     */
    public function __construct(protected string $beta) {}

    /**
     * Get the correct strategy for the current $comparison operation.
     * 
     * @param AngularMeasure $alfa The left operand of the `$comparison`.
     * @throws Error if there's no strategy for `$comparison`.
     */
    public function getStrategyFor(Comparison $comparison, AngularMeasure $alfa): Strategy
    {
        if ($comparison instanceof Equal) return new EqualString($alfa, $this->beta);
        if ($comparison instanceof Different) return new DifferentString($alfa, $this->beta);
        if ($comparison instanceof Greater) return new GreaterString($alfa, $this->beta);
        if ($comparison instanceof GreaterOrEqual) return new GreaterOrEqualString($alfa, $this->beta);
        if ($comparison instanceof Lesser) return new LesserString($alfa, $this->beta);
        if ($comparison instanceof LesserOrEqual) return new LesserOrEqualString($alfa, $this->beta);
        $unknown_class = get_class($comparison);
        throw new Error("There's no strategy for {$unknown_class} comparison.");
    }
}