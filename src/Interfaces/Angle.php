<?php

namespace MarcoConsiglio\Goniometry\Interfaces;
use MarcoConsiglio\Goniometry\Angle as AngleObject;

/**
 * The angle concept.
 */
interface Angle
{
    /**
     * Creates an angle from its values.
     *
     * @param integer $degrees
     * @param integer $minutes
     * @param float   $seconds
     * @return AngleObject
     */
    public static function createFromValues(int $degrees, int $minutes, float $seconds): AngleObject;

    /**
     * Creates an angle from its textual representation.
     *
     * @param string $angle
     * @return AngleObject
     */
    public static function createFromString(string $angle): AngleObject;

    /**
     * Creates an angle from its decimal representation.
     *
     * @param float $decimal_degrees
     * @return AngleObject
     */
    public static function createFromDecimal(float $decimal_degrees): AngleObject;

    /**
     * Creates an angle from its radian representation.
     *
     * @param float $radian
     * @return AngleObject
     */
    public static function createFromRadian(float $radian): AngleObject;

    /**
     * Reverse the direction of rotation.
     *
     * @return AngleObject
     */
    public function toggleDirection(): AngleObject;

    /**
     * Return an array containing the values
     * of degrees, minutes, seconds.
     *
     * @return array
     */
    public function getDegrees(): array;

    /**
     * Check if this angle is clockwise or negative.
     *
     * @return boolean
     */
    public function isClockwise(): bool;

    /**
     * Check if this angle is counterclockwise or positive.
     *
     * @return boolean
     */
    public function isCounterClockwise(): bool;

    /**
     * Gets the decimal degrees representation of this angle.
     *
     * @return float
     */
    public function toDecimal(): float;

    /**
     * Gets the radian representation of this angle.
     *
     * @return float
     */
    public function toRadian(): float;

    /**
     * Check if this angle is greater than $angle.
     *
     * @param string|int|float|AngleObject $angle
     * @return boolean
     */
    public function isGreaterThan(string|int|float|AngleObject $angle, int $precision = 1): bool;

    /**
     * Alias of isGreaterThan method.
     *
     * @param string|int|float|AngleObject $angle
     * @return boolean
     */
    public function gt(string|int|float|AngleObject $angle, int $precision = 1): bool;

    /**
     * Check if this angle is greater than or equal to $angle.
     *
     * @param string|int|float|AngleObject $angle
     * @param int $precision
     * @return boolean
     */
    public function isGreaterThanOrEqual(string|int|float|AngleObject $angle, int $precision = 1): bool;

    /**
     * Alias of isGreaterThanOrEqual method.
     *
     * @param string|int|float|AngleObject $angle
     * @return boolean
     */
    public function gte(string|int|float|AngleObject $angle, int $precision = 1): bool;

    /**
     * Check if this angle is less than $angle.
     *
     * @param string|int|float|AngleObject $angle
     * @return boolean
     */
    public function isLessThan(string|int|float|AngleObject $angle, int $precision = 1): bool;

    /**
     * Alias of isLessThan method.
     *
     * @param string|int|float|AngleObject $angle
     */
    public function lt(string|int|float|AngleObject $angle, int $precision = 1): bool;

    /**
     * Check if this angle is less than or equal to $angle.
     *
     * @param string|int|float|AngleObject $angle
     * @return boolean
     */
    public function isLessThanOrEqual(string|int|float|AngleObject $angle, int $precision = 1): bool;

    /**
     * Alias of isLessThanOrEqual method.
     *
     * @param string|int|float|AngleObject $angle
     * @return boolean
     */
    public function lte(string|int|float|AngleObject $angle, int $precision = 1): bool;

    /**
     * Check if this angle is equal to $angle.
     *
     * @param string|int|float|AngleObject $angle
     * @return boolean
     */
    public function isEqual(string|int|float|AngleObject $angle, int $precision = 1): bool;

    /**
     * Alias of isEqual method.
     *
     * @param string|int|float|AngleObject $angle
     * @return boolean
     */
    public function eq(string|int|float|AngleObject $angle, int $precision = 1): bool;

    /**
     * Check if this angle is different than $angle.
     *
     * @param string|int|float|AngleObject $angle
     * @return boolean
     */
    public function isDifferent(string|int|float|AngleObject $angle, int $precision = 1): bool;

    /**
     * Alias for isDifferent method.
     *
     * @param string|int|float|AngleObject $angle
     * @return boolean
     */
    public function not(string|int|float|AngleObject $angle, int $precision = 1): bool;
}
