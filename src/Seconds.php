<?php
namespace MarcoConsiglio\Goniometry;

use BcMath\Number;
use MarcoConsiglio\BCMathExtended\Number as BCMathExtendedNumber;
use MarcoConsiglio\ModularArithmetic\ModularNumber;
use Stringable;

/**
 * The `Seconds` of an `Angle`.
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
     * Construct the seconds of an `Angle`.
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
    #[\Override]
    public function __toString(): string
    {
        return $this->value->value . self::MEASURE;
    }

    /**
     * Return `true` if these `Seconds` are equal to `$seconds`, `false` otherwise.
     */
    public function isEqualTo(Seconds $seconds): bool
    {
        return $this->value->eq($seconds->value);
    }

    /**
     * Alias of `isEqualTo` method.
     */
    public function eq(Seconds $seconds): bool
    {
        return $this->isEqualTo($seconds);
    }

    /**
     * Return `true` if these `Seconds` are different than `$seconds`, `false` otherwise.
     */
    public function isDifferentThan(Seconds $seconds): bool
    {
        return $this->value->not($seconds->value);
    }

    /**
     * Alias of `isDifferentThan` method.
     */
    public function not(Seconds $seconds): bool
    {
        return $this->isDifferentThan($seconds);
    }

    /**
     * Return `true` if these `Seconds` are greater than `$seconds`, `false` otherwise.
     */
    public function isGreaterThan(Seconds $seconds): bool
    {
        return $this->value->gt($seconds->value);
    }

    /**
     * Alias of `isGreaterThan` method.
     */
    public function gt(Seconds $seconds): bool
    {
        return $this->isGreaterThan($seconds);
    }

    /**
     * Return `true` if these `Seconds` are greater than or equal to `$seconds`, `false` otherwise.
     */
    public function isGreaterThanOrEqual(Seconds $seconds): bool
    {
        return $this->value->gte($seconds->value);
    }

    /**
     * Alias of `isGreaterThanOrEqual` method.
     */
    public function gte(Seconds $seconds): bool
    {
        return $this->isGreaterThanOrEqual($seconds);
    }

    /**
     * Return `true` if these `Seconds` are less than `$seconds`, `false` otherwise.
     */
    public function isLessThan(Seconds $seconds): bool
    {
        return $this->value->lt($seconds->value);
    }

    /**
     * Alias of `isLessThan` method.
     */
    public function lt(Seconds $seconds): bool
    {
        return $this->isLessThan($seconds);
    }

    /**
     * Return `true` if these `Seconds` are less than or equal `$seconds`, `false` otherwise.
     */
    public function isLessThanOrEqual(Seconds $seconds): bool
    {
        return $this->value->lte($seconds->value);
    }

    /**
     * Alias of `isLessThanOrEqual` method.
     */
    public function lte(Seconds $seconds): bool
    {
        return $this->isLessThanOrEqual($seconds);
    }
}