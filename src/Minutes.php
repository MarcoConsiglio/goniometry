<?php
namespace MarcoConsiglio\Goniometry;

use BcMath\Number;
use MarcoConsiglio\BCMathExtended\Number as BCMathExtendedNumber;
use MarcoConsiglio\ModularArithmetic\ModularNumber;
use Stringable;

/**
 * The `Minutes` of an `Angle`.
 */
class Minutes extends ModularNumber implements Stringable
{
    /**
     * The maximum allowed value in minutes.
     */
    public const int MAX = 60;

    /**
     * The symbol for the unit of measurement of minutes.
     */
    public const string MEASURE = "'";

    /**
     * Construct the minutes of an `Angle`.
     */
    public function __construct(int|float|string|Number|BCMathExtendedNumber $minutes)
    {
        parent::__construct($minutes, self::MAX);
    }

    /**
     * Cast minutes to string.
     */
    #[\Override]
    public function __toString(): string
    {
        return $this->value->value . self::MEASURE;
    }

    /**
     * Return the minutes value.
     */
    public function value(): int
    {
        return (int) $this->value->value;
    }

    /**
     * Return `true` if these `Minutes` are equal to `$minutes`, false otherwise.
     */
    public function isEqualTo(Minutes $minutes): bool
    {
        return $this->value->eq($minutes->value);
    }

    /**
     * Alias of `isEqualTo` method.
     */
    public function eq(Minutes $minutes): bool
    {
        return $this->isEqualTo($minutes);
    }

    /**
     * Return `true` if these `Minutes` are different than `$minutes`, false otherwise.
     */
    public function isDifferentThan(Minutes $minutes): bool
    {
        return $this->value->not($minutes->value);
    }

    /**
     * Alias of `isDifferentThan` method.
     */
    public function not(Minutes $minutes): bool
    {
        return $this->isDifferentThan($minutes);
    }

    /**
     * Return `true` if these `Minutes` are greater than `$minutes`, false otherwise.
     */
    public function isGreaterThan(Minutes $minutes): bool
    {
        return $this->value->gt($minutes->value);
    }

    /**
     * Alias of `isGreaterThan` method.
     */
    public function gt(Minutes $minutes): bool
    {
        return $this->isGreaterThan($minutes);
    }

    /**
     * Return `true` if these `Minutes` are greater than or equal to `$minutes`, false otherwise.
     */
    public function isGreaterThanOrEqual(Minutes $minutes): bool
    {
        return $this->value->gte($minutes->value);
    }

    /**
     * Alias of `isGreaterThanOrEqual` method.
     */
    public function gte(Minutes $minutes): bool
    {
        return $this->isGreaterThanOrEqual($minutes);
    }

    /**
     * Return `true` if these `Minutes` are less than `$minutes`, false otherwise.
     */
    public function isLessThan(Minutes $minutes): bool
    {
        return $this->value->lt($minutes->value);
    }

    /**
     * Alias of `isLessThan` method.
     */
    public function lt(Minutes $minutes): bool
    {
        return $this->isLessThan($minutes);
    }

    /**
     * Return `true` if these `Minutes` are less than or equal to `$minutes`, false otherwise.
     */
    public function isLessThanOrEqual(Minutes $minutes): bool
    {
        return $this->value->lte($minutes->value);
    }

    /**
     * Alias of `isLessThanOrEqual` method.
     */
    public function lte(Minutes $minutes): bool
    {
        return $this->isLessThanOrEqual($minutes);
    }
}