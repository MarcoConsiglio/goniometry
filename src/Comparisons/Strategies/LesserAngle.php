<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;

/**
 * The strategy that compares two Angle instances to check if the first is 
 * lesser then the last.
 */
class LesserAngle extends GreaterAngle
{
    /**
     * Construct the comparison strategy.
     */
    public function __construct(Angle $alfa, Angle $beta)
    {
        parent::__construct($alfa, $beta);
    }

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        if ($this->degreesAreLess()) return true;
        if ($this->degreesAreGreater()) return false;
        if ($this->minutesAreLess()) return true;
        if ($this->minutesAreGreater()) return false;
        if ($this->secondsAreLess()) return true;
        if ($this->secondsAreGreater()) return false;
        return false;
    }
}