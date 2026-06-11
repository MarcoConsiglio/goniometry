<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserInt as AngleLesserInt;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use Override;

class LesserInt extends AngleLesserInt
{
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