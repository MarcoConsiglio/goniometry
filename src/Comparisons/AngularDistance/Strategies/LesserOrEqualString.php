<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualString as AngleLesserOrEqualString;
use Override;

class LesserOrEqualString extends AngleLesserOrEqualString
{
    #[Override]
    public function compare(): bool
    {
        $beta = AngularDistance::createFromString($this->beta);
        return
            new EqualAngularDistance($this->alfa, $beta)->compare() ||
            new LesserAngularDistance($this->alfa, $beta)->compare();
    }
}