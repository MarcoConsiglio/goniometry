<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use Override;

/**
 * The strategy that compares two `AngularDistance` instances to check if the first is 
 * lesser then the last.
 * 
 * @internal
 */
class LesserAngularDistance implements Strategy
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
     * Return `true` if `$alfa` is positive and `$beta` is negative.
     */
    protected function alfaIsPositiveBetaIsNegative(): bool
    {
        return 
            $this->alfa->direction === Rotation::COUNTER_CLOCKWISE &&
            $this->beta->direction === Rotation::CLOCKWISE;
    }

    /**
     * Return `true` if `$alfa` is negative and `$beta` is positive.
     */
    protected function alfaIsNegativeBetaIsPositive(): bool
    {
        return
            $this->alfa->direction === Rotation::CLOCKWISE &&
            $this->beta->direction === Rotation::COUNTER_CLOCKWISE;
    }

    /**
     * Return `true` if `$alfa->degrees` are greater than `$beta->degrees`, `false` 
     * otherwise.
     */
    protected function degreesAreGreater(): bool
    {
        return $this->degrees($this->alfa)->gt($this->degrees($this->beta));
    }

    /**
     * Return `true` if `$alfa->degrees` are less than `$beta->degrees`, `false` 
     * otherwise.
     */
    protected function degreesAreLess(): bool
    {
        return $this->degrees($this->alfa)->lt($this->degrees($this->beta));
    }

    /**
     * Return `true` if `$alfa->minutes` are greater than `$beta->minutes`, `false` 
     * otherwise.
     */
    protected function minutesAreGreater(): bool
    {
        return $this->minutes($this->alfa)->gt($this->minutes($this->beta));
    }

    /**
     * Return `true` if `$alfa->minutes` are less than `$beta->minutes`, `false` 
     * otherwise.
     */
    protected function minutesAreLess(): bool
    {
        return $this->minutes($this->alfa)->lt($this->minutes($this->beta));
    }

    /**
     * Return `true` if `$alfa->seconds` are greater than `$beta->seconds`, `false` 
     * otherwise.
     */
    protected function secondsAreGreater(): bool
    {
        return $this->seconds($this->alfa)->gt($this->seconds($this->beta));
    }

    /**
     * Return `true` if `$alfa->seconds` are less than `$beta->seconds`, `false` 
     * otherwise.
     */
    protected function secondsAreLess(): bool
    {
        return $this->seconds($this->alfa)->lt($this->seconds($this->beta));
    }

    /**
     * Return the relative degrees value of `$angle`.
     */
    protected function degrees(AngularDistance $angle): Number
    {
        return $angle->degrees->value->mul($angle->direction->value);
    }

    /**
     * Return the relative minutes value of `$angle`.
     */
    protected function minutes(AngularDistance $angle): Number
    {
        return $angle->minutes->value->mul($angle->direction->value);
    }

    /**
     * Return the relative seconds value of `$angle`.
     */
    protected function seconds(AngularDistance $angle): Number
    {
        return $angle->seconds->value->mul($angle->direction->value);
    }
}