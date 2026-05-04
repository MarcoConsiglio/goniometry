<?php
namespace MarcoConsiglio\Goniometry;

use BcMath\Number as BCMathNumber;
use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Interfaces\Scalar;
use MarcoConsiglio\ModularArithmetic\Builders\FromExtremes;
use MarcoConsiglio\ModularArithmetic\ModularRelativeNumber;
use Override;

class AngularDistanceRadian extends ModularRelativeNumber implements Scalar
{
    /**
     * The maximum allowed radian value.
     */
    public const float MAX = M_PI;

    /**
     * The minimum allowed radian value.
     */
    public const float MIN = -self::MAX;

    public function __construct(int|float|string|BCMathNumber|Number $value)
    {
        $value = Number::normalize($value);
        parent::__construct(new FromExtremes(
            $value, self::MIN, self::MAX
        ));
    }

    #[Override]
    public function value(int|null $precision = null): float
    {
        return $this->value->toFloat($precision);
    }

    /**
     * Return the max allowed radian with a precision up to 54 decimal places.
     */
    public static function getMaxRadian(): Number
    {
        return Number::π();
    }
}