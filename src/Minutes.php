<?php
namespace MarcoConsiglio\Goniometry;

use BcMath\Number;
use MarcoConsiglio\BCMathExtended\Number as BCMathExtendedNumber;
use Marcoconsiglio\ModularArithmetic\ModularNumber;
use Stringable;

/**
 * The minutes of an Angle.
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
     * Construct the minutes of an Angle.
     */
    public function __construct(int|float|string|Number|BCMathExtendedNumber $minutes)
    {
        return parent::__construct($minutes, self::MAX);
    }

    /**
     * Cast minutes to string.
     */
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

    public function isEqualTo(Minutes $minutes): bool
    {
        return $this->value->eq($minutes->value);
    }

    public function eq(Minutes $minutes): bool
    {
        return $this->isEqualTo($minutes);
    }

    public function isDifferentThan(Minutes $minutes): bool
    {
        return $this->value->not($minutes->value);
    }

    public function not(Minutes $minutes): bool
    {
        return $this->isDifferentThan($minutes);
    }

    public function isGreaterThan(Minutes $minutes): bool
    {
        return $this->value->gt($minutes->value);
    }

    public function gt(Minutes $minutes): bool
    {
        return $this->isGreaterThan($minutes);
    }

    public function isGreaterThanOrEqual(Minutes $minutes): bool
    {
        return $this->value->gte($minutes->value);
    }

    public function gte(Minutes $minutes): bool
    {
        return $this->isGreaterThanOrEqual($minutes);
    }

    public function isLessThan(Minutes $minutes): bool
    {
        return $this->value->lt($minutes->value);
    }

    public function lt(Minutes $minutes): bool
    {
        return $this->isLessThan($minutes);
    }

    public function isLessThanOrEqual(Minutes $minutes): bool
    {
        return $this->value->lte($minutes->value);
    }

    public function lte(Minutes $minutes): bool
    {
        return $this->isLessThanOrEqual($minutes);
    }
}