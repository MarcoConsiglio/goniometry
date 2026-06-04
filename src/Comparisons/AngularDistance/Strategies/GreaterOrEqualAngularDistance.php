<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualAngle;
use Override;

class GreaterOrEqualAngularDistance extends GreaterOrEqualAngle
{
    #[Override]
    public function compare(): bool
    {
        return
            new EqualAngularDistance($this->alfa, $this->beta)->compare() ||
            new GreaterAngularDistance($this->alfa, $this->beta)->compare();
    }
}