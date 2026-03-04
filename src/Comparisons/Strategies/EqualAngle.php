<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;

/**
 * The strategy that compares two Angle instances to check if they are equal.
 */
class EqualAngle extends ComparisonStrategy
{
    /**
     * The left comparison operand.
     */
    protected Angle $alfa;

    /**
     * The right comparison operand.
     */
    protected Angle $beta;

    /**
     * Construct the comparison strategy.
     */
    public function __construct(Angle $alfa, Angle $beta)
    {
        parent::__construct($alfa);
        $this->beta = $beta;
    }

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        if (! $this->secondsAreEqual()) return false;
        if (! $this->minutesAreEqual()) return false;
        if (! $this->degreesAreEqual()) return false;
        return true;
    }

    /**
     * Return true if $alfa->seconds are equal to $beta->seconds, false 
     * otherwise.
     */
    protected function secondsAreEqual(): bool
    {
        return $this->alfa->degrees->eq($this->beta->degrees);
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