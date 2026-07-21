<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\Fuzzy;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Comparisons\ComparisonStrategy;
use MarcoConsiglio\Goniometry\Interfaces\Angle\Comparable;
use MarcoConsiglio\Goniometry\SexadecimalAngle;
use Override;

/**
 * The strategy that compares two `Angle` instances to check if they are equal
 * inside an acceptable error.
 * 
 * @internal
 */
class EqualAngle extends ComparisonStrategy
{
    /**
     * The error `Angle`.
     */
    protected Angle $epsilon;

    /**
     * The low extreme of delta.
     */
    protected AngularMeasure $low_extreme;

    /**
     * The high extreme of delta.
     */
    protected AngularMeasure $high_extreme;

    /**
     * Construct the comparison strategy.
     * 
     * @param AngularMeasure $alfa The left comparison operand.
     * @param AngularMeasure $beta The right comparison operand.
     * @param Angle $delta The error within which the comparison is succesful.
     */
    public function __construct(
        protected AngularMeasure $alfa, 
        protected AngularMeasure $beta, 
        protected Angle $delta
    ) {
        $this->calcEpsilon();
        $this->calcLowExtreme();
        $this->calcHighExtreme();
    }

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        // $min ≤ $alfa ≤ $max
        if ($this->low_extreme->gt($this->high_extreme))
            return 
                $this->alfa->gte($this->low_extreme) ||
                $this->alfa->lte($this->high_extreme);
        else
            return
                $this->alfa->gte($this->low_extreme) &&
                $this->alfa->lte($this->high_extreme);
    }

    /**
     * Calc the epsilon error.
     */
    protected function calcEpsilon(): void
    {
        $width = $this->delta->toSexadecimalDegrees()->value->abs();
        $this->epsilon = Angle::createFromDecimal(
            new SexadecimalAngle($width->div(2))
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