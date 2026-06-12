<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserString as AngleLesserString;
use Override;

class LesserString extends AngleLesserString
{
    #[Override]
    public function compare(): bool
    {
        return new LesserAngularDistance(
            $this->alfa,
            AngularDistance::createFromString($this->beta)
        )->compare();
    }
}