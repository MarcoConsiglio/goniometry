<?php
namespace MarcoConsiglio\Goniometry\Casting\Sexadecimal;

use MarcoConsiglio\Goniometry\Casting\Sexagesimal;
use MarcoConsiglio\Goniometry\Interfaces\Casting\ToSexadecimal;
use MarcoConsiglio\Goniometry\Interfaces\SexadecimalValue;

/**
 * Round a sexadecimal value.
 */
class Round extends Sexagesimal implements ToSexadecimal
{
    /**
     * Construct the `Round` object.
     */
    public function __construct(
        protected SexadecimalValue $sexadecimal,
        protected int|null $precision = null
    ) {}

    /**
     * Cast to float.
     */
    public function cast(): float
    {
        if ($this->hasPrecisionBeenSet()) {
            $this->normalizePrecision();
            return $this->sexadecimalToFloat($this->precision);
        }
        return $this->sexadecimalToFloat();
    }

    /**
     * Return the sexadecimal degrees value as a 'float` type variable.
     */
    protected function sexadecimalToFloat(int|null $precision = null): float
    {
        return $this->sexadecimal->value->toFloat($precision);
    }
}