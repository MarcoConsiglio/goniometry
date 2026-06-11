<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualFloat as AngleGreaterOrEqualFloat;
use Override;

class GreaterOrEqualFloat extends AngleGreaterOrEqualFloat
{
    public function __construct(AngularDistance $alfa, float $beta, int $precision = 54)
    {
        parent::__construct($alfa, $beta, $precision);
    }

    /**
     * Perform the comparison.
     */
    #[Override]
    public function compare(): bool
    {
        return
            $this->alfa->toSexadecimalDegrees()->value->round($this->precision)
            ->gte(
                new Number($this->beta)->round($this->precision)
            );
    }    
}