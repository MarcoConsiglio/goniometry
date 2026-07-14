<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\Fuzzy;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\Fuzzy\EqualAngle;
use Override;

/**
 * The strategy that compares two `AngularDistance` instances to check if they are equal
 * inside an acceptable error.
 * 
 * @internal
 */
class EqualAngularDistance extends EqualAngle
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularDistance $alfa The left comparison operand.
     * @param AngularDistance $beta The right comparison operand.
     * @param Angle $delta The error within which the comparison is succesful.
     */
    public function __construct(AngularDistance $alfa, AngularDistance $beta, Angle $delta)
    {
        parent::__construct($alfa, $beta, $delta);
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
}