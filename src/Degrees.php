<?php
namespace MarcoConsiglio\Goniometry;

use BcMath\Number;
use MarcoConsiglio\BCMathExtended\Number as BCMathExtendedNumber;
use Marcoconsiglio\ModularArithmetic\ModularNumber;
use Stringable;

/**
 * The `Degrees` of an `Angle`.
 */
class Degrees extends ModularNumber implements Stringable
{
    /**
     * The maximum allowed value in degrees.
     */
    public const int MAX = 360;

    /**
     * The symbol for the unit of measurement of degrees.
     */
    public const string MEASURE = '°';

    /**
     * Construct the degrees of an `Angle`.
     */
    public function __construct(int|float|string|Number|BCMathExtendedNumber $degrees)
    {
        parent::__construct($degrees, self::MAX);
    }

    /**
     * Return the degrees value.
     */
    public function value(): int
    {
        return (int) $this->value->value;
    }

    /**
     * Cast degrees to string.
     */
    public function __toString(): string
    {
        return $this->value->value . self::MEASURE;
    }

    /**
     * Return `true` if these `Degrees` are equal to `$degrees`, `false` 
     * otherwise.
     */
    public function isEqualTo(Degrees $degrees): bool
    {
        return $this->value->eq($degrees->value);
    }

    /**
     * Alias of `isEqualTo` method.
     */
    public function eq(Degrees $degrees): bool
    {
        return $this->isEqualTo($degrees);
    }

    /**
     * Return `true` if these `Degrees` are different than `$degrees`, `false` 
     * otherwise.
     */
    public function isDifferentThan(Degrees $degrees): bool
    {
        return $this->value->not($degrees->value);
    }

    /**
     * Alias of `isDifferentThan` method.
     */
    public function not(Degrees $degrees): bool
    {
        return $this->isDifferentThan($degrees);
    }

    /**
     * Return `true` if these `Degrees` are greater than `$degrees`, `false` 
     * otherwise.
     */
    public function isGreaterThan(Degrees $degrees): bool
    {
        return $this->value->gt($degrees->value);
    }

    /**
     * Alias of `isGreaterThan` method.
     */
    public function gt(Degrees $degrees): bool
    {
        return $this->isGreaterThan($degrees);
    }

    /**
     * Return `true` if these `Degrees` are greater than or equal to `$degrees`,
     * `false` otherwise.
     */
    public function isGreaterThanOrEqual(Degrees $degrees): bool
    {
        return $this->value->gte($degrees->value);
    }

    /**
     * Alias of `isGreaterThanOrEqual` method.
     */
    public function gte(Degrees $degrees): bool
    {
        return $this->isGreaterThanOrEqual($degrees);
    }

    /**
     * Return `true` if these `Degrees` are less than `$degrees`, `false` 
     * otherwise.
     */
    public function isLessThan(Degrees $degrees): bool
    {
        return $this->value->lt($degrees->value);
    }

    /**
     * Alias of `isLessThan` method.
     */
    public function lt(Degrees $degrees): bool
    {
        return $this->isLessThan($degrees);
    }

    /**
     * Return `true` if these `Degrees` are less than or equal to `$degrees`, 
     * `false` otherwise.
     */
    public function isLessThanOrEqual(Degrees $degrees): bool
    {
        return $this->value->lte($degrees->value);
    }

    /**
     * Alias of `isLessThanOrEqual` method.
     */
    public function lte(Degrees $degrees): bool
    {
        return $this->isLessThanOrEqual($degrees);
    }
}