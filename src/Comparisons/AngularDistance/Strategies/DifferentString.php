<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentString as AngleDifferentString;
use Override;

class DifferentString extends AngleDifferentString
{
    #[Override]
    public function compare(): bool
    {
        return ! new EqualString($this->alfa, $this->beta)->compare();
    }
}