<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserFloat as AngleLesserFloat;
use Override;

class LesserFloat extends AngleLesserFloat
{
    public function __construct(AngularDistance $alfa, float $beta, int $precision = 54)
    {
        parent::__construct($alfa, $beta, $precision);
    }

    #[Override]
    public function compare(): bool
    {
        return 
            $this->alfa->toSexadecimalDegrees()->value->round($this->precision)
            ->lt(new Number($this->beta)->round($this->precision));
    }
}