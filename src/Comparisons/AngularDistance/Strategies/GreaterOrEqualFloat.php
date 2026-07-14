<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualFloat as AngleGreaterOrEqualFloat;
use Override;

/**
 * The strategy that compares an `AngularDistance` instance against a sexadecimal angle 
 * measure to check if the first is greater or equal than the last.
 * 
 * @internal
 */
class GreaterOrEqualFloat extends AngleGreaterOrEqualFloat
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