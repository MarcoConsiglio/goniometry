<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types;

use Error;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\DifferentFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\EqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\GreaterOrEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserFloat;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\LesserOrEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Comparisons\Different;
use MarcoConsiglio\Goniometry\Comparisons\Equal;
use MarcoConsiglio\Goniometry\Comparisons\Greater;
use MarcoConsiglio\Goniometry\Comparisons\GreaterOrEqual;
use MarcoConsiglio\Goniometry\Comparisons\Lesser;
use MarcoConsiglio\Goniometry\Comparisons\LesserOrEqual;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use Override;

/**
 * The beta `InputType` in a comparison between alfa and beta angles when
 * `$beta` is a `float`.
 * 
 * @internal
 */
class FloatType extends InputType
{
    /**
     * Construct the `InputType` of `$beta`.
     * 
     * @param float $beta The right operand of the comparison.
     * @param int $precision The number of decimal places used in the comparison.
     */
    public function __construct(
        protected float $beta, 
        protected int $precision = Comparison::MAX_PRECISION
    ) {}

    /**
     * Get the correct strategy for the current `$comparison` operation.
     * 
     * @param AngularDistance $alfa The left operand of the `$comparison`.
     * @throws Error if there's no strategy for `$comparison`.
     */
    #[Override]
    public function getStrategyFor(Comparison $comparison, AngularDistance $alfa): Strategy
    {
        if ($comparison instanceof Equal) return new EqualFloat($alfa, $this->beta, $this->precision);
        if ($comparison instanceof Different) return new DifferentFloat($alfa, $this->beta, $this->precision);
        if ($comparison instanceof Greater) return new GreaterFloat($alfa, $this->beta, $this->precision);
        if ($comparison instanceof GreaterOrEqual) return new GreaterOrEqualFloat($alfa, $this->beta, $this->precision);
        if ($comparison instanceof Lesser) return new LesserFloat($alfa, $this->beta, $this->precision);
        if ($comparison instanceof LesserOrEqual) return new LesserOrEqualFloat($alfa, $this->beta);
        return $this->throwError($comparison);
    }
}