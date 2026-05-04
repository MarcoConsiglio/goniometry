<?php
namespace MarcoConsiglio\Goniometry;

use BcMath\Number as BCMathNumber;
use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Interfaces\SexadecimalValue;
use MarcoConsiglio\ModularArithmetic\Builders\FromExtremes;
use MarcoConsiglio\ModularArithmetic\ModularRelativeNumber;
use Override;

class SexadecimalAngularDistance extends ModularRelativeNumber implements SexadecimalValue
{

    /**
     * The symbol for the unit of measurement of sexadecimal degrees.
     */
    public const string MEASURE = '°';

    /**
     * The maximum allowed value.
     */
    public const int MAX = 180;

    /**
     * The minimum allowed value.
     */
    public const int MIN = -self::MAX;

    /**
     * Construct a `SexadecimalAngularDistance` number.
     */
    public function __construct(int|float|string|BCMathNumber|Number $value)
    {
        $value = Number::normalize($value);
        parent::__construct(
            new FromExtremes($value, self::MIN, self::MAX)
        );
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
    public function toggleDirection(): SexadecimalAngularDistance
    {
        return new SexadecimalAngularDistance($this->value->opposite());
    }
}