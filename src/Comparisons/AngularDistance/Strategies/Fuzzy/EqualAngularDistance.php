<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\Fuzzy;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\Fuzzy\EqualAngle;
use Override;

class EqualAngularDistance extends EqualAngle
{
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