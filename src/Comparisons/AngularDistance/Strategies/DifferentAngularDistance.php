<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentAngle;
use Override;

class DifferentAngularDistance extends DifferentAngle
{
    #[Override]
    public function compare(): bool
    {
        return ! new EqualAngularDistance($this->alfa, $this->beta)->compare();
    }
}