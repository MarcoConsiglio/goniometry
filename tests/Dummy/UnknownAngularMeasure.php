<?php
namespace MarcoConsiglio\Goniometry\Tests\Dummy;

use Exception;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\SexadecimalAngle;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use Override;

class UnknownAngularMeasure extends Angle
{
    public function __construct()
    {}

    #[Override]
    public static function createFromValues(
        int $degrees = 0, 
        int $minutes = 0, 
        float $seconds = 0.0, 
        Rotation $direction = Rotation::COUNTER_CLOCKWISE
    ): static
    {
        throw new Exception('Not implemented');
    }

    #[Override]
    public static function createFromString(string $sexagesimal): static
    {
        throw new Exception('Not implemented');
    }

    #[Override]
    public function absolute(): static
    {
        throw new Exception('Not implemented');
    }

    #[Override]
    public function asb(): static
    {
        throw new Exception('Not implemented');
    }

    #[Override]
    public function oppositeRotation(): static
    {
        throw new Exception('Not implemented');
    }

    #[Override]
    public function oppositeDirection(): static
    {
        throw new Exception('Not implemented');
    }

    #[Override]
    public function isClockwise(): bool
    {
        throw new Exception('Not implemented');
    }

    #[Override]
    public function isCounterClockwise(): bool
    {
        throw new Exception('Not implemented');
    }

    #[Override]
    public function toSexagesimalDegrees(): SexagesimalDegrees
    {
        throw new Exception('Not implemented');
    }

    #[Override]
    public function toSexadecimalDegrees(): SexadecimalAngle
    {
        throw new Exception('Not implemented');
    }

    #[Override]
    public function toFloat(int|null $precision = null): float
    {
        throw new Exception('Not implemented');
    }

    #[Override]
    public function toRadian(int|null $precision = null): float
    {
        throw new Exception('Not implemented');
    }

    #[Override]
    public function __toString(): string
    {
        throw new Exception('Not implemented');
    }
}