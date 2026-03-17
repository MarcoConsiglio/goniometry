<?php

namespace MarcoConsiglio\Goniometry\Interfaces;

/**
 * The behavior of an angle.
 */
interface Angle
{
    /**
     * Creates an `Angle` from its values.
     */
    public static function createFromValues(int $degrees, int $minutes, float $seconds): Angle;

    /**
     * Creates an `Angle` from its textual representation.
     */
    public static function createFromString(string $sexagesimal): Angle;

    /**
     * Creates an `Angle` from its decimal representation.
     */
    public static function createFromDecimal(float $sexadecimal): Angle;

    /**
     * Creates an `Angle` from its radian representation.
     */
    public static function createFromRadian(float $radian): Angle;

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
     * Gets the decimal degrees representation of this angle.
     */
    public function toFloat(): float;

    /**
     * Gets the radian representation of this angle.
     */
    public function toRadian(): float;

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
}
