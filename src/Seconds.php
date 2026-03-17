<?php
namespace MarcoConsiglio\Goniometry;

use BcMath\Number;
use MarcoConsiglio\BCMathExtended\Number as BCMathExtendedNumber;
use Marcoconsiglio\ModularArithmetic\ModularNumber;
use Stringable;

/**
 * The seconds of an Angle.
 */
class Seconds extends ModularNumber implements Stringable
{
    /**
     * The maximum allowed value in seconds.
     */
    public const int MAX = 60;

    /**
     * The symbol for the unit of measurement of seconds.
     */
    public const string MEASURE = '"';

    /**
     * Construct the seconds of an Angle.
     */
    public function __construct(int|float|string|Number|BCMathExtendedNumber $seconds)
    {
        parent::__construct($seconds, self::MAX);
    }

    /**
     * Return the seconds value.
     */
    public function value(int|null $precision = null): float
    {
        return $this->value->toFloat($precision);
    }

    /**
     * Cast seconds to string.
     */
    public function __toString(): string
    {
        return $this->value->value . self::MEASURE;
    }

    public function isEqualTo(Seconds $seconds): bool
    {
        return $this->value->eq($seconds->value);
    }

    public function eq(Seconds $seconds): bool
    {
        return $this->isEqualTo($seconds);
    }

    public function isDifferentThan(Seconds $seconds): bool
    {
        return $this->value->not($seconds->value);
    }

    public function not(Seconds $seconds): bool
    {
        return $this->isDifferentThan($seconds);
    }

    public function isGreaterThan(Seconds $seconds): bool
    {
        return $this->value->gt($seconds->value);
    }

    public function gt(Seconds $seconds): bool
    {
        return $this->isGreaterThan($seconds);
    }

    public function isGreaterThanOrEqual(Seconds $seconds): bool
    {
        return $this->value->gte($seconds->value);
    }

    public function gte(Seconds $seconds): bool
    {
        return $this->isGreaterThanOrEqual($seconds);
    }

    public function isLessThan(Seconds $seconds): bool
    {
        return $this->value->lt($seconds->value);
    }

    public function lt(Seconds $seconds): bool
    {
        return $this->isLessThan($seconds);
    }

    public function isLessThanOrEqual(Seconds $seconds): bool
    {
        return $this->value->lte($seconds->value);
    }

    public function lte(Seconds $seconds): bool
    {
        return $this->isLessThanOrEqual($seconds);
    }
}