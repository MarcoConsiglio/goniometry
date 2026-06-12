<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentInt as AngleDifferentInt;
use Override;

class DifferentInt extends AngleDifferentInt
{
    #[Override]
    public function compare(): bool
    {
        return ! new EqualInt($this->alfa, $this->beta)->compare();
    }
}