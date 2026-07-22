<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Types;

use Error;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Different;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Greater;
use MarcoConsiglio\Goniometry\Comparisons\Angle\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentString;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualString;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualString;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterString;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualString;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserString;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\InputType;
use MarcoConsiglio\Goniometry\Comparisons\Angle\LesserOrEqual;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

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
     * @param Angle $alfa The left operand of the `$comparison`.
     * @throws Error if there's no strategy for `$comparison`.
     */
    public function getStrategyFor(Comparison $comparison, Angle $alfa): Strategy
    {
        if ($comparison instanceof Equal) return new EqualString($alfa, $this->beta);
        if ($comparison instanceof Different) return new DifferentString($alfa, $this->beta);
        if ($comparison instanceof Greater) return new GreaterString($alfa, $this->beta);
        if ($comparison instanceof GreaterOrEqual) return new GreaterOrEqualString($alfa, $this->beta);
        if ($comparison instanceof Lesser) return new LesserString($alfa, $this->beta);
        if ($comparison instanceof LesserOrEqual) return new LesserOrEqualString($alfa, $this->beta);
        return $this->throwError($comparison);
    }
}