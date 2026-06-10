<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualAngle;
use Override;

class LesserOrEqualAngularDistance extends LesserOrEqualAngle
{
    #[Override]
    public function compare(): bool
    {
        return
            new EqualAngularDistance($this->alfa, $this->beta)->compare() ||
            new LesserAngularDistance($this->alfa, $this->beta)->compare();
    }
}