<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;
use RoundingMode;

class EqualFloat extends ComparisonStrategy
{
    public function __construct(
        Angle $alfa, 
        protected float $beta, 
        protected int $precision = PHP_FLOAT_DIG
    ) {
        assert($precision >= 0 && $precision <= PHP_FLOAT_DIG);
        parent::__construct($alfa);
    }

    public function compare(): bool
    {
        return 
            $this->alfa->toDecimal($this->precision) == 
            new Number($this->beta)->toFloat($this->precision);
    }
}