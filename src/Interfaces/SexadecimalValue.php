<?php
namespace MarcoConsiglio\Goniometry\Interfaces;

use BcMath\Number as BCMathNumber;
use MarcoConsiglio\BCMathExtended\Number;

/**
 * The behavior of a sexadecimal scalar value.
 */
interface SexadecimalValue extends Scalar
{
    /**
     * Construct a `SexadecimalValue` number.
     */
    public function __construct(int|float|string|BCMathNumber|Number $value);

    /**
     * Return the sexadecimal `float` value.
     * 
     * @param int|null $precision Round the number to `$precision` decimal 
     * places.
     */
    public function value(int|null $precision = null): float;

    /**
     * Return a `SexadecimalValue` with opposite direction.
     */
    public function toggleDirection(): SexadecimalValue;
}