<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterFloat as AngleGreaterFloat;
use Override;

class GreaterFloat extends AngleGreaterFloat
{
    public function __construct(AngularDistance $alfa, float $beta, int $precision = 54)
    {
        parent::__construct($alfa, $beta, $precision);
    }

    #[Override]
    public function compare(): bool
    {
        return 
            $this->alfa->toSexadecimalDegrees()->value->round($this->precision)->gt(
                new Number($this->beta)->round($this->precision)
            );
    }
}