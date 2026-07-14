<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserInt as AngleLesserInt;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use Override;

/**
 * The strategy that compares an `AngularDistance` instance against a sexagesimal degrees 
 * measure of an angle to check if the first is lesser than the last.
 * 
 * @internal
 */
class LesserInt extends AngleLesserInt
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
        return new LesserAngularDistance(
            $this->alfa,
            AngularDistance::createFromValues(
                degrees: $this->beta,
                direction:
                    $this->beta >= 0 ?
                    Rotation::COUNTER_CLOCKWISE :
                    Rotation::CLOCKWISE
            )
        )->compare();
    }
}