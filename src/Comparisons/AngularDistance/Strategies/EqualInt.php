<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualInt as AngleEqualInt;
use Override;
use MarcoConsiglio\Goniometry\Enums\Rotation;

class EqualInt extends AngleEqualInt
{
    public function __construct(AngularDistance $alfa, int $beta)
    {
        parent::__construct($alfa, $beta);
    }

    #[Override]
    public function compare(): bool
    {
        return new EqualAngularDistance(
            $this->alfa,
            AngularDistance::createFromValues(
                degrees: abs($this->beta),
                direction: $this->beta >= 0 ? 
                    Rotation::COUNTER_CLOCKWISE : 
                    Rotation::CLOCKWISE
            )
        )->compare();
    }
}