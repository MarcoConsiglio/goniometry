<?php
namespace MarcoConsiglio\Goniometry;

use MarcoConsiglio\Goniometry\Enums\Direction;

/**
 * The `SexagesimalDegrees` composed of `Degrees`, `Minutes`, `Seconds` and `Direction`.
 */
class SexagesimalDegrees
{
    /**
     * Construct a SexagesimalDegrees structure.
     */
    public function __construct(
        public protected(set) Degrees $degrees,
        public protected(set) Minutes $minutes,
        public protected(set) Seconds $seconds,
        public protected(set) Direction $direction
    ) {}
}