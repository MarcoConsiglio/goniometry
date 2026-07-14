<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterFloat as AngleGreaterFloat;
use Override;

/**
 * The strategy that compares an `AngularDistance` instance against a sexadecimal angle 
 * measure to check if the first is greater than the last.
 * 
 * @internal
 */
class GreaterFloat extends AngleGreaterFloat
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularDistance $alfa The left comparison operand.
     * @param float $beta The right comparison operand.
     */
    public function __construct(AngularDistance $alfa, float $beta)
    {
        parent::__construct($alfa, $beta);
    }

    #[Override]
    public function compare(): bool
    {
        if ($this->bothAre180()) return false;
        return 
            $this->alfa->toSexadecimalDegrees()->value->round($this->precision)->gt(
                new Number($this->beta)->round($this->precision)
            );
    }

    protected function bothAre180(): bool
    {
        return 
            $this->alfa->toSexadecimalDegrees()->valueObject()->abs()->round($this->precision)
            ->eq(new Number($this->beta)->abs()->round($this->precision));
    }
}