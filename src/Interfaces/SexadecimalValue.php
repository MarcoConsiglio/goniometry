<?php
namespace MarcoConsiglio\Goniometry\Interfaces;

use BcMath\Number as BCMathNumber;
use MarcoConsiglio\BCMathExtended\Number;

interface SexadecimalValue extends Scalar
{
    /**
     * Construct a `SexadecimalValue` number.
     */
    public function __construct(int|float|string|BCMathNumber|Number $value);

    /**
     * Return the sexadecimal `float` value.
     */
    public function value(int|null $precision = null): float;

    public function toggleDirection(): SexadecimalValue;
}