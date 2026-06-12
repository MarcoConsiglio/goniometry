<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualString as AngleEqualString;
use Override;

class EqualString extends AngleEqualString
{
    #[Override]
    public function compare(): bool
    {
        return new EqualAngularDistance(
            $this->alfa,
            AngularDistance::createFromString($this->beta)
        )->compare();
    }
}