<?php
namespace MarcoConsiglio\Goniometry\Enums;

/**
 * The rotation of an angle.
 */
enum Rotation: int
{
    /**
     * Positive rotation.
     */
    case COUNTER_CLOCKWISE = 1;

    /**
     * Negative rotation.
     */
    case CLOCKWISE = -1;

    /**
     * Return the opposite direction.
     * 
     * @codeCoverageIgnore
     */
    public function opposite(): Rotation
    {
        return match($this) {
            Rotation::COUNTER_CLOCKWISE => Rotation::CLOCKWISE,
            Rotation::CLOCKWISE => Rotation::COUNTER_CLOCKWISE
        };
    }
}