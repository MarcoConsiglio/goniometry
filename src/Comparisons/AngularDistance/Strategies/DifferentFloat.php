<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentFloat as AngleDifferentFloat;
use Override;

class DifferentFloat extends AngleDifferentFloat
{
    #[Override]
    public function compare(): bool
    {
        return ! new EqualFloat($this->alfa, $this->beta, $this->precision)->compare();
    }
}