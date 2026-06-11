<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterInt as AngleGreaterInt;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use Override;

class GreaterInt extends AngleGreaterInt
{
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