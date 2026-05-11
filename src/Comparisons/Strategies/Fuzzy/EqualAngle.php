<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies\Fuzzy;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Strategies\EqualAngle as EqualAngleStrategy;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;

/**
 * The strategy that compares two `Angle` instances to check if they are equal
 * inside an acceptable error.
 * 
 * @internal
 */
class EqualAngle extends EqualAngleStrategy
{
    /**
     * The error `Angle`.
     */
    protected AngleInterface $epsilon;

    /**
     * The low extreme of delta.
     */
    protected AngleInterface $low_extreme;

    /**
     * The high extreme of delta.
     */
    protected AngleInterface $high_extreme;

    /**
     * Construct the comparison strategy.
     * 
     * @param AngleInterface $alfa The left comparison operand.
     * @param AngleInterface $beta The right comparison operand.
     * @param AngleInterface $delta The error within which the comparison is succesful.
     */
    public function __construct(
        AngleInterface $alfa, 
        AngleInterface $beta, 
        protected AngleInterface $delta
    ) {
        parent::__construct($alfa, $beta);
        $this->calcEpsilon();
        $this->calcLowExtreme();
        $this->calcHighExtreme();
    }

    /**
     * Perform the comparison.
     */
    #[\Override]
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
        $this->epsilon = Angle::createFromDecimal(
            new SexadecimalDegrees($width->div(2))
        );
    }

    /**
     * Calc the low extreme of `$delta`.
     */
    protected function calcLowExtreme(): void
    {
        $this->low_extreme = $this->beta->absSum(
            $this->epsilon->oppositeRotation()
        );
    }

    /**
     * Calc the high extreme of `$delta`.
     */
    protected function calcHighExtreme(): void
    {
        $this->high_extreme = $this->beta->absSum($this->epsilon);
    }
}