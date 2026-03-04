<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;

/**
 * The strategy that compares two Angle instances to check if the first is 
 * greater than the last.
 */
class GreaterAngle extends ComparisonStrategy
{
    /**
     * The left comparison operand.
     */
    protected Angle $alfa;

    /**
     * The right comparison operand.
     */
    protected angle $beta;

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
        if ($this->degreesAreGreater()) return true;
        if ($this->degreesAreLess()) return false;
        if ($this->minutesAreGreater()) return true;
        if ($this->minutesAreLess()) return false;
        if ($this->secondsAreGreater()) return true;
        if ($this->secondsAreLess()) return false;
        return false;
    }

    /**
     * Return true if $alfa->degrees is greater than beta->degrees, false 
     * otherwise.
     */
    public function degreesAreGreater(): bool
    {
        return $this->alfa->degrees->gt($this->beta->degrees);
    }

    /**
     * Return true if $alfa->degrees is less than $beta->degrees, false 
     * otherwise.
     */
    public function degreesAreLess(): bool
    {
        return $this->alfa->degrees->lt($this->beta->degrees);
    }

    /**
     * Return true if $alfa->minutes is greater than $beta->minutes, false 
     * otherwise.
     */
    public function minutesAreGreater(): bool
    {
        return $this->alfa->minutes->gt($this->beta->minutes);
    }

    /**
     * Return true if $alfa->minutes is less than $beta->minutes, false 
     * otherwise.
     */
    public function minutesAreLess(): bool
    {
        return $this->alfa->minutes->lt($this->beta->minutes);
    }

    /**
     * Return true if $alfa->seconds is greater than $beta->seconds, false 
     * otherwise.
     */
    public function secondsAreGreater(): bool
    {
        return $this->alfa->seconds->gt($this->beta->seconds);
    }

    /**
     * Return true if $alfa->seconds is less than $beta->seconds, false 
     * otherwise.
     */
    public function secondsAreLess(): bool
    {
        return $this->alfa->seconds->lt($this->beta->seconds);
    }
}