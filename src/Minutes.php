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
    public const MAX = 60;

    /**
     * The symbol for the unit of measurement of seconds.
     */
    protected const string MEASURE = "'";

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
}