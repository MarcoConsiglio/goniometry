<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies;

use MarcoConsiglio\Goniometry\AngularMeasure;
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
     * @param AngularMeasure $alfa The left comparison operand.
     * @param AngularMeasure $beta The right comparison operand.
     */
    public function __construct(AngularMeasure $alfa, AngularMeasure $beta)
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
        return $this->secondsAreLess();
    }
}