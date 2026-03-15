<?php
namespace MarcoConsiglio\Goniometry;

use MarcoConsiglio\Goniometry\Enums\Direction;
use Stringable;

/**
 * The `SexagesimalDegrees` composed of `Degrees`, `Minutes`, `Seconds` and `Direction`.
 */
class SexagesimalDegrees implements Stringable
{
    /**
     * Construct a SexagesimalDegrees structure.
     */
    public function __construct(
        public Degrees $degrees,
        public Minutes $minutes,
        public Seconds $seconds,
        public Direction $direction
    ) {}

    /**
     * Cast this instance to `string` type.
     */
    public function __toString(): string
    {
        $sign = 
            $this->direction == Direction::CLOCKWISE ?
            '-' : '';
        return "{$sign}{$this->degrees} {$this->minutes} {$this->seconds}";
    }
}