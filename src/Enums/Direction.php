<?php
namespace MarcoConsiglio\Goniometry\Enums;

/**
 * The direction of an `Angle`.
 */
enum Direction: int
{
    /**
     * Positive direction.
     */
    case COUNTER_CLOCKWISE = 1;

    /**
     * Negative direction.
     */
    case CLOCKWISE = -1;

    /**
     * Return the opposite direction.
     * 
     * @codeCoverageIgnore
     */
    public function opposite(): Direction
    {
        return match($this) {
            Direction::COUNTER_CLOCKWISE => Direction::CLOCKWISE,
            Direction::CLOCKWISE => Direction::COUNTER_CLOCKWISE
        };
    }
}