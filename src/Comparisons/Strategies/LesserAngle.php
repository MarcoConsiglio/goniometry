<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;
use Override;

/**
 * The strategy that compares two `Angle` instances to check if the first is 
 * lesser then the last.
 * 
 * @internal
 */
class LesserAngle extends GreaterAngle
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngleInterface $alfa The left comparison operand.
     * @param AngleInterface $beta The right comparison operand.
     */
    public function __construct(AngleInterface $alfa, AngleInterface $beta)
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