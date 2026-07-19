<?php
namespace MarcoConsiglio\Goniometry\Tests\Dummy;

use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Interfaces\SexadecimalValue;
use MarcoConsiglio\Goniometry\Interfaces\Summable;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use Override;

class UnknownAngularMeasure extends AngularMeasure
{
    public function __construct()
    {}

    #[Override]
    public static function createFromValues(int $degrees, int $minutes, float $seconds, Rotation $direction): static
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public static function createFromString(string $sexagesimal): static
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function absolute(): static
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function asb(): static
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function oppositeRotation(): static
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function oppositeDirection(): static
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function isClockwise(): bool
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function isCounterClockwise(): bool
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function toSexagesimalDegrees(): SexagesimalDegrees
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function toSexadecimalDegrees(): SexadecimalValue
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function toFloat(int $precision = PHP_FLOAT_DIG): float
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function toRadian(int $precision = PHP_FLOAT_DIG): float
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function sum(Summable&AngularMeasure $addend): static
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function absSum(Summable&AngularMeasure $addend): static
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function __toString(): string
    {
        throw new \Exception('Not implemented');
    }
}