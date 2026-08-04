<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

/**
 * The strategy that compares two `AngularDistance` instances to check if the first is 
 * greater than the last.
 * 
 * @internal
 */
class GreaterAngularDistance implements Strategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularDistance $alfa The left comparison operand.
     * @param AngularDistance $beta The right comparison operand.
     */
    public function __construct(
        protected AngularDistance $alfa, 
        protected AngularDistance $beta
    ) {}

    public function compare(): bool
    {
        if ($this->bothAre180()) return false;
        if ($this->alfaIsNegativeBetaIsPositive()) return false;
        if ($this->alfaIsPositiveBetaIsNegative()) return true;
        if ($this->degreesAreGreater()) return true;
        if ($this->degreesAreLess()) return false;
        if ($this->minutesAreGreater()) return true;
        if ($this->minutesAreLess()) return false;
        if ($this->secondsAreGreater()) return true;
        return ! $this->secondsAreLess();
    }

    /**
     * Return `true` if both $alfa and $beta are ±180°.
     */
    protected function bothAre180(): bool
    {
        return
            $this->alfa->degrees->eq(new Degrees(180)) &&
            $this->beta->degrees->eq(new Degrees(180));
    }

    /**
     * Return `true` if `$alfa` is positive while `$beta` is negative.
     */
    protected function alfaIsPositiveBetaIsNegative(): bool
    {
        return 
            $this->alfa->direction === Rotation::COUNTER_CLOCKWISE &&
            $this->beta->direction === Rotation::CLOCKWISE;
    }

    /**
     * Return `true` if `$alfa` is negative while `$beta` is positive.
     */
    protected function alfaIsNegativeBetaIsPositive(): bool
    {
        return
            $this->alfa->direction === Rotation::CLOCKWISE &&
            $this->beta->direction === Rotation::COUNTER_CLOCKWISE;
    }

    /**
     * Return true if `$alfa->degrees` are greter than `$beta->degrees`, false 
     * otherwise.
     */
    protected function degreesAreGreater(): bool
    {
        return 
            $this->alfa->degrees->value->mul($this->alfa->direction->value)->gt(
                $this->beta->degrees->value->mul($this->beta->direction->value)
            );
    }

    /**
     * Return true if `$alfa->degrees` are less than `$beta->degrees`, false 
     * otherwise.
     */
    protected function degreesAreLess(): bool
    {
        return 
            $this->alfa->degrees->value->mul($this->alfa->direction->value)->lt(
                $this->beta->degrees->value->mul($this->beta->direction->value)
            );
    }

    /**
     * Return true if `$alfa->minutes` are greater than `$beta->minutes`, false 
     * otherwise.
     */
    protected function minutesAreGreater(): bool
    {
        return 
            $this->alfa->minutes->value->mul($this->alfa->direction->value)->gt(
                $this->beta->minutes->value->mul($this->beta->direction->value)
            );
    }

    /**
     * Return true if `$alfa->minutes` are less than `$beta->minutes`, false 
     * otherwise.
     */
    protected function minutesAreLess(): bool
    {
        return 
            $this->alfa->minutes->value->mul($this->alfa->direction->value)->lt(
                $this->beta->minutes->value->mul($this->beta->direction->value)
            );
    }

    /**
     * Return true if `$alfa->seconds` are greater than `$beta->seconds`, false 
     * otherwise.
     */
    protected function secondsAreGreater(): bool
    {
        return 
            $this->alfa->seconds->value->mul($this->alfa->direction->value)->gt(
                $this->beta->seconds->value->mul($this->beta->direction->value)
            );
    }

    /**
     * Return true if `$alfa->seconds` are less than `$beta->seconds`, false 
     * otherwise.
     */
    protected function secondsAreLess(): bool
    {
        return 
            $this->alfa->seconds->value->mul($this->alfa->direction->value)->lt(
                $this->beta->seconds->value->mul($this->beta->direction->value)
            );
    }
}