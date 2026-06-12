<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualInt as AngleGreaterOrEqualInt;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use Override;

class GreaterOrEqualInt extends AngleGreaterOrEqualInt
{
    #[Override]
    public function compare(): bool
    {
        $beta = AngularDistance::createFromValues(
            degrees: $this->beta,
            direction: $this->beta >= 0 ?
                Rotation::COUNTER_CLOCKWISE :
                Rotation::CLOCKWISE    
        );
        return 
            new EqualAngularDistance($this->alfa, $beta)->compare() ||
            new GreaterAngularDistance($this->alfa, $beta)->compare();
    }
}