<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\EqualFloat as AngleEqualFloat;
use Override;

/**
 * The strategy that compares an `AngularDistance` instance against a sexadecimal angle 
 * measure to check if they are equal.
 * 
 * @internal
 */
class EqualFloat extends AngleEqualFloat
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularDistance $alfa The left comparison operand.
     * @param float $beta The right comparison operand.
     * @param int $precision The precision used in the comparison.
     */
    public function __construct(AngularDistance $alfa, float $beta, int $precision = 54)
    {
        parent::__construct($alfa, $beta, $precision);
    }

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