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
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentFloat;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterFloat;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserFloat;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualFloat;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\InputType;
use MarcoConsiglio\Goniometry\Comparisons\Angle\LesserOrEqual;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

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
     * @param Angle $alfa The left operand of the `$comparison`.
     * @throws Error if there's no strategy for `$comparison`.
     */
    public function getStrategyFor(Comparison $comparison, Angle $alfa): Strategy
    {
        if ($comparison instanceof Equal) return new EqualFloat($alfa, $this->beta, $this->precision);
        if ($comparison instanceof Different) return new DifferentFloat($alfa, $this->beta, $this->precision);
        if ($comparison instanceof Greater) return new GreaterFloat($alfa, $this->beta, $this->precision);
        if ($comparison instanceof GreaterOrEqual) return new GreaterOrEqualFloat($alfa, $this->beta, $this->precision);
        if ($comparison instanceof Lesser) return new LesserFloat($alfa, $this->beta, $this->precision);
        if ($comparison instanceof LesserOrEqual) return new LesserOrEqualFloat($alfa, $this->beta, $this->precision);
        return $this->throwError($comparison); // @codeCoverageIgnore
    }
}