<?php
namespace MarcoConsiglio\Goniometry;

use MarcoConsiglio\Goniometry\Enums\Rotation;
use Stringable;

/**
 * The `SexagesimalDegrees` type composed of `Degrees`, `Minutes`, `Seconds` and `Rotation`.
 */
class SexagesimalDegrees implements Stringable
{
    /**
     * Construct a `SexagesimalDegrees`.
     */
    public function __construct(
        public Degrees $degrees,
        public Minutes $minutes,
        public Seconds $seconds,
        public Rotation $direction
    ) {}

    /**
     * Cast this instance to `string` type.
     */
    public function __toString(): string
    {
        $sign = 
            $this->direction == Rotation::CLOCKWISE ?
            '-' : '';
        return "{$sign}{$this->degrees} {$this->minutes} {$this->seconds}";
    }
}