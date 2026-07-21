<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

/**
 * The strategy that compares two `AngularDistance` instances to check if they are equal.
 * 
 * @internal
 */
class EqualAngularDistance implements Strategy
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
        if ($this->bothAre180()) return true;
        if (! $this->rotationDirectionsAreEqual()) return false;
        if (! $this->secondsAreEqual()) return false;
        if (! $this->minutesAreEqual()) return false;
        return $this->degreesAreEqual();
    }

    /**
     * Return true if `$alfa->seconds` are equal to `$beta->seconds`, false 
     * otherwise.
     */
    protected function secondsAreEqual(): bool
    {
        return $this->alfa->seconds->eq($this->beta->seconds);
    }

    /**
     * Return true if `$alfa->minutes` are equal to `$beta->minutes`, false 
     * otherwise.
     */
    protected function minutesAreEqual(): bool
    {
        return $this->alfa->minutes->eq($this->beta->minutes);
    }

    /**
     * Return true if `$alfa->degrees` are equal to `$beta->degrees`, false 
     * otherwise.
     */
    protected function degreesAreEqual(): bool
    {
        return $this->alfa->degrees->eq($this->beta->degrees);
    }

    /**
     * Return true if both `$alfa` and `$beta` share the same rotation direction.
     */
    protected function rotationDirectionsAreEqual(): bool
    {
        return $this->alfa->direction === $this->beta->direction;
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
}