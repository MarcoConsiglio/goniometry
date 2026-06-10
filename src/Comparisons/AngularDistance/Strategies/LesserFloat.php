<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserFloat as AngleLesserFloat;
use Override;

class LesserFloat extends AngleLesserFloat
{
    #[Override]
    public function compare(): bool
    {
        return 
            $this->alfa->toSexadecimalDegrees()->value->round($this->precision)
            ->lt(new Number($this->beta)->round($this->precision));
    }
}