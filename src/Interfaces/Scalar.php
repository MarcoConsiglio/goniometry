<?php
namespace MarcoConsiglio\Goniometry\Interfaces;

/**
 * The behavior of a scalar value.
 */
interface Scalar
{
    /**
     * Return the value of a scalar.
     */
    public function value(): int|float;
}