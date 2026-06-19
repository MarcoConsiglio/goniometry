<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserAngle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use Override;

class LesserAngularDistance extends LesserAngle
{
    #[Override]
    public function compare(): bool
    {
        if ($this->bothAre180()) return false;
        if ($this->alfaIsPositiveBetaIsNegative()) return false;
        if ($this->alfaIsNegativeBetaIsPositive()) return true;
        if ($this->degreesAreGreater()) return false;
        if ($this->degreesAreLess()) return true;
        if ($this->minutesAreGreater()) return false;
        if ($this->minutesAreLess()) return true;
        if ($this->secondsAreGreater()) return false;
        return $this->secondsAreLess();
    }

    protected function bothAre180(): bool
    {
        return 
            $this->alfa->degrees->eq(new Degrees(180)) &&
            $this->beta->degrees->eq(new Degrees(180));
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

    #[Override]
    protected function degreesAreGreater(): bool
    {
        return $this->degrees($this->alfa)->gt($this->degrees($this->beta));
    }

    #[Override]
    protected function degreesAreLess(): bool
    {
        return $this->degrees($this->alfa)->lt($this->degrees($this->beta));
    }

    #[Override]
    protected function minutesAreGreater(): bool
    {
        return $this->minutes($this->alfa)->gt($this->minutes($this->beta));
    }

    #[Override]
    protected function minutesAreLess(): bool
    {
        return $this->minutes($this->alfa)->lt($this->minutes($this->beta));
    }

    #[Override]
    protected function secondsAreGreater(): bool
    {
        return $this->seconds($this->alfa)->gt($this->seconds($this->beta));
    }
    
    #[Override]
    protected function secondsAreLess(): bool
    {
        return $this->seconds($this->alfa)->lt($this->seconds($this->beta));
    }

    protected function degrees(AngularDistance $angle): Number
    {
        return $angle->degrees->value->mul($angle->direction->value);
    }

    protected function minutes(AngularDistance $angle): Number
    {
        return $angle->minutes->value->mul($angle->direction->value);
    }

    protected function seconds(AngularDistance $angle): Number
    {
        return $angle->seconds->value->mul($angle->direction->value);
    }
}