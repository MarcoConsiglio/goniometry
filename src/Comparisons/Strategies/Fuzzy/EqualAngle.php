<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies\Fuzzy;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualAngle as EqualAngleStrategy;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use Override;

/**
 * The strategy that compares two `Angle` instances to check if they are equal
 * inside an acceptable error.
 */
class EqualAngle extends EqualAngleStrategy
{
    /**
     * The error `Angle`.
     */
    protected Angle $epsilon;

    /**
     * The low extreme of delta.
     */
    protected Angle $low_extreme;

    /**
     * The high extreme of delta.
     */
    protected Angle $high_extreme;

    /**
     * Construct the comparison strategy.
     * 
     * @param Angle $alfa The left comparison operand.
     * @param Angle $beta The right comparison operand.
     * @param Angle $delta The error within which the comparison is succesful.
     */
    public function __construct(
        Angle $alfa, 
        Angle $beta, 
        protected Angle $delta
    ) {
        parent::__construct($alfa, $beta);
        $this->calcEpsilon();
        $this->calcLowExtreme();
        $this->calcHighExtreme();
    }

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        $alfa = $this->alfa->toSexadecimalDegrees()->value;
        $beta = $this->beta->toSexadecimalDegrees()->value;
        $difference = $alfa->sub($beta)->abs();
        $complementary_difference = new Number(Degrees::MAX)->sub($difference);
        $distance = Number::min($difference, $complementary_difference);
        return $this->delta->toSexadecimalDegrees()->value->gte($distance);
    }

    /**
     * Calc the epsilon error.
     */
    protected function calcEpsilon(): void
    {
        $width = $this->delta->toSexadecimalDegrees()->value->abs();
        $half_width = $width->div(2);
        $this->epsilon = Angle::createFromDecimal(new SexadecimalDegrees($half_width));
    }

    /**
     * Calc the low extreme of `$delta`.
     */
    protected function calcLowExtreme(): void
    {
        $this->low_extreme = Angle::absSum(
            $this->beta, $this->epsilon->toggleDirection()
        );
    }

    /**
     * Calc the high extreme of `$delta`.
     */
    protected function calcHighExtreme(): void
    {
        $this->high_extreme = Angle::absSum(
            $this->beta, $this->epsilon
        );
    }
}