<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualFloat as AngleEqualFloat;
use Override;

class EqualFloat extends AngleEqualFloat
{
    #[Override]
    public function compare(): bool
    {
        if ($this->bothAre180()) return true;
        return $this->alfa->toSexadecimalDegrees()->valueObject()->round($this->precision)
            ->eq(new Number($this->beta)->round($this->precision));
    }

    protected function bothAre180(): bool
    {
        return 
            $this->alfa->toSexadecimalDegrees()->valueObject()->abs()->round($this->precision)
            ->eq(new Number($this->beta)->abs()->round($this->precision));
    }
}