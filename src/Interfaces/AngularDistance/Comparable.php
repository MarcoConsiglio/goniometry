<?php
namespace MarcoConsiglio\Goniometry\Interfaces\AngularDistance;

use MarcoConsiglio\Goniometry\AngularDistance;

interface Comparable
{
    /**
     * Check if this angle is greater than $angle.
     */
    public function isGreaterThan(string|int|float|AngularDistance $angle, int $precision = 54): bool;

    /**
     * Alias of isGreaterThan method.
     */
    public function gt(string|int|float|AngularDistance $angle, int $precision = 54): bool;

    /**
     * Check if this angle is greater than or equal to $angle.
     */
    public function isGreaterThanOrEqualTo(string|int|float|AngularDistance $angle, int $precision = 54): bool;

    /**
     * Alias of isGreaterThanOrEqual method.
     */
    public function gte(string|int|float|AngularDistance $angle, int $precision = 54): bool;

    /**
     * Check if this angle is less than $angle.
     */
    public function isLessThan(string|int|float|AngularDistance $angle, int $precision = 54): bool;

    /**
     * Alias of isLessThan method.
     */
    public function lt(string|int|float|AngularDistance $angle, int $precision = 54): bool;

    /**
     * Check if this angle is less than or equal to $angle.
     */
    public function isLessThanOrEqualTo(string|int|float|AngularDistance $angle, int $precision = 54): bool;

    /**
     * Alias of isLessThanOrEqual method.
     */
    public function lte(string|int|float|AngularDistance $angle, int $precision = 54): bool;

    /**
     * Check if this angle is equal to $angle.
     */
    public function isEqualTo(string|int|float|AngularDistance $angle, int $precision = 54): bool;

    /**
     * Alias of isEqual method.
     */
    public function eq(string|int|float|AngularDistance $angle, int $precision = 54): bool;

    /**
     * Check if this angle is different than $angle.
     */
    public function isDifferentThan(string|int|float|AngularDistance $angle, int $precision = 54): bool;

    /**
     * Alias for isDifferent method.
     */
    public function not(string|int|float|AngularDistance $angle, int $precision = 54): bool;

}