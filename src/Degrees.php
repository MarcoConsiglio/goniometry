<?php
namespace MarcoConsiglio\Goniometry;

use BcMath\Number;
use MarcoConsiglio\BCMathExtended\Number as BCMathExtendedNumber;
use Marcoconsiglio\ModularArithmetic\ModularNumber;
use Stringable;

/**
 * The degrees of an Angle.
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
     * Construct the degrees of an Angle.
     */
    public function __construct(int|float|string|Number|BCMathExtendedNumber $degrees)
    {
        parent::__construct($degrees, self::MAX);
    }

    /**
     * Cast degrees to string.
     */
    public function __toString(): string
    {
        return $this->value->value . self::MEASURE;
    }

    public function isEqualTo(Degrees $degrees): bool
    {
        return $this->value->eq($degrees->value);
    }

    public function eq(Degrees $degrees): bool
    {
        return $this->isEqualTo($degrees);
    }

    public function isDifferentThan(Degrees $degrees): bool
    {
        return $this->value->not($degrees->value);
    }

    public function not(Degrees $degrees): bool
    {
        return $this->isDifferentThan($degrees);
    }

    public function isGreaterThan(Degrees $degrees): bool
    {
        return $this->value->gt($degrees->value);
    }

    public function gt(Degrees $degrees): bool
    {
        return $this->isGreaterThan($degrees);
    }

    public function isGreaterThanOrEqual(Degrees $degrees): bool
    {
        return $this->value->gte($degrees->value);
    }

    public function gte(Degrees $degrees): bool
    {
        return $this->isGreaterThanOrEqual($degrees);
    }

    public function isLessThan(Degrees $degrees): bool
    {
        return $this->value->lt($degrees->value);
    }

    public function lt(Degrees $degrees): bool
    {
        return $this->isLessThan($degrees);
    }

    public function isLessThanOrEqual(Degrees $degrees): bool
    {
        return $this->value->lte($degrees->value);
    }

    public function lte(Degrees $degrees): bool
    {
        return $this->isLessThanOrEqual($degrees);
    }
}