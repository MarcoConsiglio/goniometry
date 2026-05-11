<?php

namespace MarcoConsiglio\Goniometry\Interfaces;

use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;

/**
 * The behavior of an angle.
 */
interface Angle
{
    /**
     * Create an `Angle` from its sexagesimal values.
     */
    public static function createFromValues(
        int $degrees, 
        int $minutes, 
        float $seconds, 
        Direction $direction
    ): Angle;

    /**
     * Create an `Angle` from its textual representation.
     */
    public static function createFromString(string $sexagesimal): Angle;

    /**
     * Create an `Angle` from its decimal representation.
     */
    public static function createFromDecimal(float $sexadecimal): Angle;

    /**
     * Create an `Angle` from its radian representation.
     */
    public static function createFromRadian(float $radian): Angle;

    /**
     * Return an absolute `Angle`
     */
    public function absolute(): Angle;

    /**
     * Alias of `absolute()` method.
     */
    public function asb(): Angle;

    /**
     * Reverse the direction of rotation.
     */
    public function toggleDirection(): Angle;

    /**
     * Return an array containing the values
     * of degrees, minutes, seconds.
     */
    public function getDegrees(): array;

    /**
     * Check if this angle is clockwise or negative.
     */
    public function isClockwise(): bool;

    /**
     * Check if this angle is counterclockwise or positive.
     */
    public function isCounterClockwise(): bool;

    /**
     * Return the sexagesimal values of this `Angle`.
     */
    public function toSexagesimalDegrees(): SexagesimalDegrees;

    /**
     * Return the sexadecimal values of this `Angle`.
     */
    public function toSexadecimalDegrees(): SexadecimalValue;

    /**
     * Cast this `Angle` to its `float` sexadecimal degrees representation.
     */
    public function toFloat(int $precision = PHP_FLOAT_DIG): float;

    /**
     * Cast this `Angle` to its `float` radian representation.
     */
    public function toRadian(int $precision = PHP_FLOAT_DIG): float;

    /**
     * Check if this angle is greater than $angle.
     */
    public function isGreaterThan(string|int|float|Angle $angle, int $precision = 54): bool;

    /**
     * Alias of isGreaterThan method.
     */
    public function gt(string|int|float|Angle $angle, int $precision = 54): bool;

    /**
     * Check if this angle is greater than or equal to $angle.
     */
    public function isGreaterThanOrEqualTo(string|int|float|Angle $angle, int $precision = 54): bool;

    /**
     * Alias of isGreaterThanOrEqual method.
     */
    public function gte(string|int|float|Angle $angle, int $precision = 54): bool;

    /**
     * Check if this angle is less than $angle.
     */
    public function isLessThan(string|int|float|Angle $angle, int $precision = 54): bool;

    /**
     * Alias of isLessThan method.
     */
    public function lt(string|int|float|Angle $angle, int $precision = 54): bool;

    /**
     * Check if this angle is less than or equal to $angle.
     */
    public function isLessThanOrEqualTo(string|int|float|Angle $angle, int $precision = 54): bool;

    /**
     * Alias of isLessThanOrEqual method.
     */
    public function lte(string|int|float|Angle $angle, int $precision = 54): bool;

    /**
     * Check if this angle is equal to $angle.
     */
    public function isEqualTo(string|int|float|Angle $angle, int $precision = 54): bool;

    /**
     * Alias of isEqual method.
     */
    public function eq(string|int|float|Angle $angle, int $precision = 54): bool;

    /**
     * Check if this angle is different than $angle.
     */
    public function isDifferentThan(string|int|float|Angle $angle, int $precision = 54): bool;

    /**
     * Alias for isDifferent method.
     */
    public function not(string|int|float|Angle $angle, int $precision = 54): bool;

    /**
     * Check if this `Angle` is equal to `$beta` within an acceptable `$delta` 
     * error angle.
     */
    public function fuzzyEqual(Angle $beta, Angle $delta): bool;

    /**
     * Alias for `fuzzyEqual()` method.
     */
    public function feq(Angle $beta, Angle $delta): bool;

    /**
     * The sum between two `Angle`s. The resulting `Angle` can be positive or negative.
     */
    public function sum(Angle $addend): Angle;

    /**
     * The sum between two `Angle`s. The resulting `Angle` can only be positive.
     */
    public function absSum(Angle $addend): Angle;

    /**
     * Return the opposite `Angle`.
     */
    public function opposite(): Angle;
}
