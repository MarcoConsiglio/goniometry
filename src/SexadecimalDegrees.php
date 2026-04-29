<?php
namespace MarcoConsiglio\Goniometry;

use BcMath\Number as BCMathNumber;
use MarcoConsiglio\BCMathExtended\Number;
use Marcoconsiglio\ModularArithmetic\ModularNumber;
use Stringable;

/**
 * The value of an `Angle` expressed as sexadecimal degrees.
 */
class SexadecimalDegrees extends ModularNumber implements Stringable
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
        $value = $this->normalizeArgument($value);
        if ($value->isPositive())
            parent::__construct($value, Degrees::MAX);
        else
            parent::__construct($value, -Degrees::MAX);
    }

    /**
     * Return the sexadecimal value.
     */
    public function value(int|null $precision = null): float
    {
        return $this->value->toFloat($precision);
    }

    /**
     * Cast this instance to `string` type.
     */
    #[\Override]
    public function __toString(): string
    {
        return "{$this->value}" . self::MEASURE;
    }
}