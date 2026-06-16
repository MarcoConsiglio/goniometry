<?php
namespace MarcoConsiglio\Goniometry\Tests\Dummy;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Builders\Angle\AngleBuilder;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Interfaces\Angle as InterfacesAngle;
use MarcoConsiglio\Goniometry\Interfaces\SexadecimalValue;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use Override;

class UnknownAngularMeasure extends AngularMeasure
{
    public function __construct()
    {}

    #[Override]
    public static function createFromValues(int $degrees, int $minutes, float $seconds, Rotation $direction): AngularMeasure
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public static function createFromString(string $sexagesimal): InterfacesAngle
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public static function createFromDecimal(float $sexadecimal): InterfacesAngle
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public static function createFromRadian(float $radian): InterfacesAngle
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function absolute(): InterfacesAngle
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function asb(): InterfacesAngle
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function oppositeRotation(): InterfacesAngle
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function oppositeDirection(): InterfacesAngle
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function getDegrees(): array
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
    public function isEqualTo(string|int|float|InterfacesAngle $angle, int $precision = 54): bool
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function eq(string|int|float|InterfacesAngle $angle, int $precision = 54): bool
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function isGreaterThan(string|int|float|InterfacesAngle $angle, int $precision = 54): bool
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function gt(string|int|float|InterfacesAngle $angle, int $precision = 54): bool
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function isGreaterThanOrEqualTo(string|int|float|InterfacesAngle $angle, int $precision = 54): bool
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function gte(string|int|float|InterfacesAngle $angle, int $precision = 54): bool
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function isLessThan(string|int|float|InterfacesAngle $angle, int $precision = 54): bool
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function lt(string|int|float|InterfacesAngle $angle, int $precision = 54): bool
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function isLessThanOrEqualTo(string|int|float|InterfacesAngle $angle, int $precision = 54): bool
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function lte(string|int|float|InterfacesAngle $angle, int $precision = 54): bool
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function isDifferentThan(string|int|float|InterfacesAngle $angle, int $precision = 54): bool
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function not(string|int|float|InterfacesAngle $angle, int $precision = 54): bool
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function fuzzyEqual(InterfacesAngle $beta, InterfacesAngle $delta): bool
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function feq(InterfacesAngle $beta, InterfacesAngle $delta): bool
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function sum(InterfacesAngle $addend): InterfacesAngle
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function absSum(InterfacesAngle $addend): InterfacesAngle
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function __toString(): string
    {
        throw new \Exception('Not implemented');
    }
}