<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Types;

use Error;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Different;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Greater;
use MarcoConsiglio\Goniometry\Comparisons\Angle\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\InputType;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentInt;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualInt;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterInt;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualInt;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserInt;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualInt;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Angle\LesserOrEqual;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

/**
 * The beta `InputType` in a comparison between alfa and beta angles when
 * beta is an `int`.
 * 
 * @internal
 */
class IntType extends InputType
{
    /**
     * Construct the `InputType` of `$beta`.
     * 
     * @param int $beta The right operand of the comparison.
     */
    public function __construct(protected int $beta) {}

    /**
     * Get the correct strategy for the current `$comparison` operation.
     * 
     * @param Angle $alfa The left operand of the `$comparison`.
     * @throws Error if there's no strategy for `$comparison`.
     */
    public function getStrategyFor(Comparison $comparison, Angle $alfa): Strategy
    {
        if ($comparison instanceof Equal) return new EqualInt($alfa, $this->beta);
        if ($comparison instanceof Different) return new DifferentInt($alfa, $this->beta);
        if ($comparison instanceof Greater) return new GreaterInt($alfa, $this->beta);
        if ($comparison instanceof GreaterOrEqual) return new GreaterOrEqualInt($alfa, $this->beta);
        if ($comparison instanceof Lesser) return new LesserInt($alfa, $this->beta);
        if ($comparison instanceof LesserOrEqual) return new LesserOrEqualInt($alfa, $this->beta); 
        return $this->throwError($comparison); // @codeCoverageIgnore
    }
}