<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Types;

use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\DifferentString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterOrEqualString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserOrEqualString;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserString;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

/**
 * The beta angle `InputType` in a comparison between alfa and beta angle when
 * beta is a `string`.
 */
class StringType extends InputType
{
    /**
     * Construct the `InputType` of $beta.
     */
    public function __construct(protected string $beta) {}

    /**
     * Get the correct strategy for the current $comparison operation.
     */
    public function getStrategyFor(Comparison $comparison, Angle $alfa): Strategy
    {
        if ($comparison instanceof Equal) return new EqualString($alfa, $this->beta);
        if ($comparison instanceof Different) return new DifferentString($alfa, $this->beta);
        if ($comparison instanceof Greater) return new GreaterString($alfa, $this->beta);
        if ($comparison instanceof GreaterOrEqual) return new GreaterOrEqualString($alfa, $this->beta);
        if ($comparison instanceof Lesser) return new LesserString($alfa, $this->beta);
        return new LesserOrEqualString($alfa, $this->beta);
    }
}