<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterAngle;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use Override;

class GreaterAngularDistance extends GreaterAngle
{
    #[Override]
    public function compare(): bool
    {
        if ($this->alfaIsNegativeBetaIsPositive()) return false;
        if ($this->alfaIsPositiveBetaIsNegative()) return true;
        if ($this->degreesAreGreater()) return true;
        if ($this->degreesAreLess()) return false;
        if ($this->minutesAreGreater()) return true;
        if ($this->minutesAreLess()) return false;
        if ($this->secondsAreGreater()) return true;
        return ! $this->secondsAreLess();
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
        return 
            $this->alfa->degrees->value->mul($this->alfa->direction->value)->gt(
                $this->beta->degrees->value->mul($this->beta->direction->value)
            );
    }

    #[Override]
    protected function degreesAreLess(): bool
    {
        return 
            $this->alfa->degrees->value->mul($this->alfa->direction->value)->lt(
                $this->beta->degrees->value->mul($this->beta->direction->value)
            );
    }

    #[Override]
    protected function minutesAreGreater(): bool
    {
        return 
            $this->alfa->minutes->value->mul($this->alfa->direction->value)->gt(
                $this->beta->minutes->value->mul($this->beta->direction->value)
            );
    }

    #[Override]
    protected function minutesAreLess(): bool
    {
        return 
            $this->alfa->minutes->value->mul($this->alfa->direction->value)->lt(
                $this->beta->minutes->value->mul($this->beta->direction->value)
            );
    }

    #[Override]
    protected function secondsAreGreater(): bool
    {
        return 
            $this->alfa->seconds->value->mul($this->alfa->direction->value)->gt(
                $this->beta->seconds->value->mul($this->beta->direction->value)
            );
    }

    #[Override]
    protected function secondsAreLess(): bool
    {
        return 
            $this->alfa->seconds->value->mul($this->alfa->direction->value)->lt(
                $this->beta->seconds->value->mul($this->beta->direction->value)
            );
    }
}