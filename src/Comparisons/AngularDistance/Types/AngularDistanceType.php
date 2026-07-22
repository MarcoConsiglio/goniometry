<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types;

use Error;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Different;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Equal;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Greater;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\LesserOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\DifferentAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterOrEqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserOrEqualAngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\InputType;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use Override;

/**
 * The beta `InputType` in a comparison between alfa and beta angles when
 * `$beta` is an `AngularDistance`.
 * 
 * @internal
 */
class AngularDistanceType extends InputType
{
    /**
     * Construct the `InputType` of $beta.
     * 
     * @param AngularDistance $beta The right operand of the comparison.
     */
    public function __construct(protected AngularDistance $beta) {}

    /**
     * Get the correct strategy for the current `$comparison` operation.
     * 
     * @param AngularDistance $alfa The left operand of the `$comparison`.
     * @throws Error if there's no strategy for `$comparison`.
     */
    #[Override]
    public function getStrategyFor(Comparison $comparison, AngularDistance $alfa): Strategy
    {
        if ($comparison instanceof Equal) return new EqualAngularDistance($alfa, $this->beta);
        if ($comparison instanceof Different) return new DifferentAngularDistance($alfa, $this->beta);
        if ($comparison instanceof Greater) return new GreaterAngularDistance($alfa, $this->beta);
        if ($comparison instanceof GreaterOrEqual) return new GreaterOrEqualAngularDistance($alfa, $this->beta);
        if ($comparison instanceof Lesser) return new LesserAngularDistance($alfa, $this->beta);
        if ($comparison instanceof LesserOrEqual) return new LesserOrEqualAngularDistance($alfa, $this->beta);
        return $this->throwError($comparison);
    }
}