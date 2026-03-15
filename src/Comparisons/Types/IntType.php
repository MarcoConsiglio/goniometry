<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Types;

use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\DifferentInt;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualInt;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterInt;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\GreaterOrEqualInt;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserInt;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\LesserOrEqualInt;
use MarcoConsiglio\Goniometry\Comparisons\Strategy;

/**
 * The beta angle `InputType` in a comparison between alfa and beta angle when
 * beta is an `int`.
 */
class IntType extends InputType
{
    /**
     * Construct the InputType of $beta.
     */
    public function __construct(protected int $beta) {}

    /**
     * Get the correct strategy for the current $comparison operation.
     */
    public function getStrategyFor(Comparison $comparison, Angle $alfa): Strategy
    {
        if ($comparison instanceof Equal) return new EqualInt($alfa, $this->beta);
        if ($comparison instanceof Different) return new DifferentInt($alfa, $this->beta);
        if ($comparison instanceof Greater) return new GreaterInt($alfa, $this->beta);
        if ($comparison instanceof GreaterOrEqual) return new GreaterOrEqualInt($alfa, $this->beta);
        if ($comparison instanceof Lesser) return new LesserInt($alfa, $this->beta);
        return new LesserOrEqualInt($alfa, $this->beta); 
    }
}