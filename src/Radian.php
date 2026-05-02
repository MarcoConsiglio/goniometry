<?php
namespace MarcoConsiglio\Goniometry;

use BcMath\Number as BCMathNumber;
use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Interfaces\Scalar;
use MarcoConsiglio\ModularArithmetic\ModularNumber;

/**
 * The value of an `Angle` expressed as a `Radian`.
 */
class Radian extends ModularNumber implements Scalar
{
    /**
     * The maximum allowed radian value.
     */
    public const float MAX = 2 * M_PI;

    /**
     * The minimum allowed radian value.
     */
    public const float MIN = -self::MAX;

    /**
     * Construct a `Radian` number.
     */
    public function __construct(int|float|string|BCMathNumber|Number $value)
    {
        $value = Number::normalize($value);
        $value->isPositive() ?
            parent::__construct($value, static::getMaxRadian()) :
            parent::__construct($value, static::getMaxRadian()->mul(-1));
    }

    /**
     * Return the radian value.
     */
    public function value(int|null $precision = null): float
    {
        return $this->value->toFloat($precision);
    }

    /**
     * Return the max allowed radian with a precision up to 54 decimal places.
     */
    public static function getMaxRadian(): Number
    {
        return Number::π()->mul(2);
    }
}