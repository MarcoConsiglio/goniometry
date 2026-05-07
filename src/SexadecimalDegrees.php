<?php
namespace MarcoConsiglio\Goniometry;

use BcMath\Number as BCMathNumber;
use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Interfaces\SexadecimalValue;
use MarcoConsiglio\ModularArithmetic\ModularNumber;
use Override;

/**
 * The sexadecimal value of an `Angle`.
 */
class SexadecimalDegrees extends ModularNumber implements SexadecimalValue
{
    /**
     * The symbol for the unit of measurement of sexadecimal degrees.
     */
    public const string MEASURE = '°';

    /**
     * The maximum allowed sexadecimal value.
     */
    public const float MAX = Degrees::MAX;

    /**
     * The minimum allowed sexadecimal value.
     */
    public const float MIN = -self::MAX;

    /**
     * Construct a `SexadecimalDegrees` number.
     */
    public function __construct(int|float|string|BCMathNumber|Number $value)
    {
        $value = Number::normalize($value);
        if ($value->isPositive())
            parent::__construct($value, Degrees::MAX);
        else
            parent::__construct($value, -Degrees::MAX);
    }

    /**
     * Return the `SexadecimalDegrees` value.
     */
    public function value(int|null $precision = null): float
    {
        return $this->value->toFloat($precision);
    }

    /**
     * Cast this instance to `string` type.
     */
    #[Override]
    public function __toString(): string
    {
        return "{$this->value}" . self::MEASURE;
    }

    /**
     * Return this `SexadecimalDegrees` with opposite direction.
     */
    #[Override]
    public function toggleDirection(): SexadecimalDegrees
    {
        return new SexadecimalDegrees(
            $this->value->opposite()
        );
    }
}