<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserAngle;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use Override;

class LesserAngularDistance extends LesserAngle
{
    public function __construct(AngularDistance $alfa, AngularDistance $beta)
    {
        parent::__construct($alfa, $beta);
    }

    #[Override]
    public function compare(): bool
    {
        if ($this->alfaIsPositiveBetaIsNegative()) return false;
        if ($this->alfaIsNegativeBetaIsPositive()) return true;
        if ($this->degreesAreGreater()) return false;
        if ($this->degreesAreLess()) return true;
        if ($this->minutesAreGreater()) return false;
        if ($this->minutesAreLess()) return true;
        if ($this->secondsAreGreater()) return false;
        return $this->secondsAreLess();
    }

    protected function alfaIsPositiveBetaIsNegative(): bool
    {
        return 
            $this->alfa->direction === Rotation::COUNTER_CLOCKWISE &&
            $this->beta->direction === Rotation::CLOCKWISE;
    }

    protected function alfaIsNegativeBetaIsPositive(): bool
    {
        return
            $this->alfa->direction === Rotation::CLOCKWISE &&
            $this->beta->direction === Rotation::COUNTER_CLOCKWISE;
    }
}