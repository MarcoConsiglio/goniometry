<?php
namespace MarcoConsiglio\Goniometry;

use BcMath\Number as BCMathNumber;
use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Interfaces\SexadecimalValue;
use MarcoConsiglio\ModularArithmetic\ModularNumber;
use Override;

/**
 * The value of an `Angle` expressed as sexadecimal degrees.
 */
class SexadecimalDegrees extends ModularNumber implements SexadecimalValue
{
    /**
     * The symbol for the unit of measurement of sexadecimal degrees.
     */
    public const string MEASURE = '°';

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
     * Return the sexadecimal `float` value.
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

    #[Override]
    public function toggleDirection(): SexadecimalDegrees
    {
        return new SexadecimalDegrees(
            $this->value->opposite()
        );
    }
}