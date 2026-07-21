<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\Fuzzy;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\Fuzzy\EqualAngle;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use MarcoConsiglio\Goniometry\SexadecimalAngle;
use Override;

/**
 * The strategy that compares two `AngularDistance` instances to check if they are equal
 * inside an acceptable error.
 * 
 * @internal
 */
class EqualAngularDistance implements Strategy
{
    /**
     * The error `Angle`.
     */
    protected Angle $epsilon;
    
    /**
     * The low extreme of delta.
     */
    protected AngularDistance $low_extreme;

    /**
     * The high extreme of delta.
     */
    protected AngularDistance $high_extreme;


    /**
     * Construct the comparison strategy.
     * 
     * @param AngularDistance $alfa The left comparison operand.
     * @param AngularDistance $beta The right comparison operand.
     * @param Angle $delta The error within which the comparison is succesful.
     */
    public function __construct(
        protected AngularDistance $alfa, 
        protected AngularDistance $beta, 
        protected Angle $delta
    ) {
        $this->calcEpsilon();
        $this->calcLowExtreme();
        $this->calcHighExtreme();
    }

    #[Override]
    public function compare(): bool
    {
        if ($this->extremeAreSwapped()) {
            if ($this->alfa->isCounterClockwise()) 
                return $this->isAlfaGreaterThanOrEqualToBothExtremes();
            else
                return $this->isAlfaLessThanOrEqualToBothExtremes();
        }
        return $this->isAlfaInBetweenBothExtremes();
    }

    /**
     * Return `true` if the lower extreme is greater than the higher extreme.
     */
    protected function extremeAreSwapped(): bool
    {
        return $this->low_extreme->gt($this->high_extreme);
    }

    protected function isAlfaGreaterThanOrEqualToBothExtremes(): bool
    {
        return 
            $this->alfa->gte($this->low_extreme) &&
            $this->alfa->gte($this->high_extreme);
    }

    protected function isAlfaLessThanOrEqualToBothExtremes(): bool
    {
        return
            $this->alfa->lte($this->low_extreme) &&
            $this->alfa->lte($this->high_extreme);
    }

    protected function isAlfaInBetweenBothExtremes(): bool
    {
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
        $this->low_extreme = $this->beta->sum(
            $this->epsilon->oppositeRotation()
        );
    }

    /**
     * Calc the high extreme of `$delta`.
     */
    protected function calcHighExtreme(): void
    {
        $this->high_extreme = $this->beta->sum($this->epsilon);
    }
}