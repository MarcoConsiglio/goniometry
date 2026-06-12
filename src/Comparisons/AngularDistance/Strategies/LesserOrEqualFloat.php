<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualFloat as AngleLesserOrEqualFloat;
use Override;

class LesserOrEqualFloat extends AngleLesserOrEqualFloat
{
    #[Override]
    public function compare(): bool
    {
        return 
            new EqualFloat($this->alfa, $this->beta, $this->precision)->compare() ||
            new LesserFloat($this->alfa, $this->beta, $this->precision)->compare();
    }
}