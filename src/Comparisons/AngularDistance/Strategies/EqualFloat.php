<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualFloat as AngleEqualFloat;
use Override;

class EqualFloat extends AngleEqualFloat
{
    public function __construct(AngularDistance $alfa, float $beta, int $precision = 54)
    {
        parent::__construct($alfa, $beta, $precision);
    }

    #[Override]
    public function compare(): bool
    {
        return $this->alfa->toSexadecimalDegrees()->valueObject()->round($this->precision)
            ->eq(new Number($this->beta)->round($this->precision));
    }
}