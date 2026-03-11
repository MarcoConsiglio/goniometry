<?php
namespace MarcoConsiglio\Goniometry;

use BcMath\Number as BCMathNumber;
use MarcoConsiglio\BCMathExtended\Number;
use Marcoconsiglio\ModularArithmetic\ModularNumber;

/**
 * The value of an `Angle` expressed as a `Radian`.
 */
class Radian extends ModularNumber
{
    /**
     * The max allowed radian value.
     */
    public const float MAX = 2 * M_PI;

    /**
     * Construct a `Radian` number.
     */
    public function __construct(int|float|string|BCMathNumber|Number $value)
    {
        $value = $this->normalizeArgument($value);
        if ($value->isPositive())
            parent::__construct($value, $this->getMaxRadian());
        else
            parent::__construct($value, $this->getMaxRadian()->mul(-1));
    }

    /**
     * Return the max allowed radian with a precision up to 54 decimal places.
     */
    public static function getMaxRadian(): Number
    {
        return Number::π()->mul(2);
    }
}