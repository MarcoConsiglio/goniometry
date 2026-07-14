<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies;

use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Comparisons\ComparisonStrategy;

/**
 * The strategy that compares two `Angle` instances to check if they are equal.
 * 
 * @internal
 */
class EqualAngle extends ComparisonStrategy
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularMeasure $alfa The left comparison operand.
     * @param AngularMeasure $beta The right comparison operand.
     */
    public function __construct(AngularMeasure $alfa, protected AngularMeasure $beta)
    {
        parent::__construct($alfa);
    }

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        if (! $this->secondsAreEqual()) return false;
        if (! $this->minutesAreEqual()) return false;
        return $this->degreesAreEqual();
    }

    /**
     * Return true if $alfa->seconds are equal to $beta->seconds, false 
     * otherwise.
     */
    protected function secondsAreEqual(): bool
    {
        return $this->alfa->seconds->eq($this->beta->seconds);
    }

    /**
     * Return true if $alfa->minutes are equal to $beta->minutes, false 
     * otherwise.
     */
    protected function minutesAreEqual(): bool
    {
        return $this->alfa->minutes->eq($this->beta->minutes);
    }

    /**
     * Return true if $alfa->degrees are equal to $beta->degrees, false 
     * otherwise.
     */
    protected function degreesAreEqual(): bool
    {
        return $this->alfa->degrees->eq($this->beta->degrees);
    }
}