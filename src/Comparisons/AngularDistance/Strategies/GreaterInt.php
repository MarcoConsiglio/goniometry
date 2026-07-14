<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterInt as AngleGreaterInt;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use Override;

/**
 * The strategy that compares an `AngularDistance` instance against a sexagesimal degrees 
 * measure of an angle to check if the first is greater than the last.
 * 
 * @internal
 */
class GreaterInt extends AngleGreaterInt
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularDistance $alfa The left comparison operand.
     * @param int $beta The right comparison operand.
     */
    public function __construct(AngularDistance $alfa, int $beta)
    {
        parent::__construct($alfa, $beta);
    }

    #[Override]
    public function compare(): bool
    {
        return new GreaterAngularDistance(
            $this->alfa,
            AngularDistance::createFromValues(
                degrees: abs($this->beta),
                direction: 
                    $this->beta >= 0 ?
                    Rotation::COUNTER_CLOCKWISE :
                    Rotation::CLOCKWISE
            )
        )->compare();
    }
}