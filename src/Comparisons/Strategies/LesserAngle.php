<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use Override;

/**
 * The strategy that compares two `Angle` instances to check if the first is 
 * lesser then the last.
 */
class LesserAngle extends GreaterAngle
{
    /**
     * Construct the comparison strategy.
     * 
     * @param Angle $alfa The left comparison operand.
     * @param Angle $beta The right comparison operand.
     */
    public function __construct(Angle $alfa, Angle $beta)
    {
        parent::__construct($alfa, $beta);
    }

    /**
     * Perform the comparison.
     */
    #[Override]
    public function compare(): bool
    {
        if ($this->degreesAreLess()) return true;
        if ($this->degreesAreGreater()) return false;
        if ($this->minutesAreLess()) return true;
        if ($this->minutesAreGreater()) return false;
        // if ($this->secondsAreGreater()) return false;
        return $this->secondsAreLess();
    }
}