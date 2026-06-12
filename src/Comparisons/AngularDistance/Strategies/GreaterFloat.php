<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterFloat as AngleGreaterFloat;
use Override;

class GreaterFloat extends AngleGreaterFloat
{
    #[Override]
    public function compare(): bool
    {
        return 
            $this->alfa->toSexadecimalDegrees()->value->round($this->precision)->gt(
                new Number($this->beta)->round($this->precision)
            );
    }
}