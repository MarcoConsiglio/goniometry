<?php
namespace MarcoConsiglio\Goniometry\Casting\Sexadecimal;

use MarcoConsiglio\BCMathExtended\Number;

/**
 * Cast an `Angle` to a sexadecimal value when the same `Angle` has already 
 * been constructed with a sexadecimal value.
 */
class Round implements ToSexadecimal
{
    /**
     * Construct the `Round` object.
     */
    public function __construct(
        protected float $original_decimal,
        protected int|null $precision = null
    ) {}

    /**
     * Cast to float.
     */
    public function cast(): float
    {
        if ($this->hasPrecisionBeenSet()) {
            $this->normalizePrecision();
            return new Number($this->original_decimal)->toFloat($this->precision);
        }
        return $this->original_decimal;
    }

    /**
     * Check if the precision has been set.
     */
    protected function hasPrecisionBeenSet(): bool
    {
        return $this->precision !== null;
    }

    /**
     * Normalize the precision to a suitable precision
     * when casting to float.
     */
    protected function normalizePrecision(): void
    {
        $this->precision = 
            abs($this->precision) > PHP_FLOAT_DIG ? 
            PHP_FLOAT_DIG : abs($this->precision);
    }
}