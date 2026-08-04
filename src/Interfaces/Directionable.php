<?php
namespace MarcoConsiglio\Goniometry\Interfaces;

interface Directionable
{
    /**
     * Return an absolute angle, that is a `COUNTER_CLOCKWISE` angle.
     */
    public function absolute(): static;

    /**
     * Alias of `absolute()` method.
     */
    public function asb(): static;

    /**
     * Return an angle with the opposite direction of rotation.
     */
    public function oppositeRotation(): static;

    /**
     * Return the opposite direction angle.
     */
    public function oppositeDirection(): static;

    /**
     * Check if this angle is clockwise or negative.
     */
    public function isClockwise(): bool;

    /**
     * Check if this angle is counterclockwise or positive.
     */
    public function isCounterClockwise(): bool;
}