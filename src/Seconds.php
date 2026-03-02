<?php
namespace MarcoConsiglio\Goniometry;

use BcMath\Number;
use MarcoConsiglio\BCMathExtended\Number as BCMathExtendedNumber;
use Marcoconsiglio\ModularArithmetic\ModularNumber;

/**
 * The seconds of an Angle.
 */
class Seconds extends ModularNumber
{
    /**
     * The maximum allowed value in seconds.
     */
    public const int MAX = 60;

    /**
     * The symbol for the unit of measurement of seconds.
     */
    protected const string MEASURE = '"';

    /**
     * Construct the seconds of an Angle.
     */
    public function __construct(int|float|string|Number|BCMathExtendedNumber $seconds)
    {
        parent::__construct($seconds, self::MAX);
    }

    /**
     * Cast seconds to string.
     */
    public function __toString(): string
    {
        return $this->value->value . self::MEASURE;
    }
}