<?php
namespace MarcoConsiglio\Goniometry;

use BcMath\Number;
use MarcoConsiglio\BCMathExtended\Number as BCMathExtendedNumber;
use Marcoconsiglio\ModularArithmetic\ModularNumber;
use Stringable;

/**
 * The degrees of an Angle.
 */
class Degrees extends ModularNumber implements Stringable
{
    /**
     * The maximum allowed value in degrees.
     */
    public const MAX = 360;

    /**
     * The symbol for the unit of measurement of seconds.
     */
    protected const string MEASURE = '°';

    /**
     * Construct the degrees of an Angle.
     */
    public function __construct(int|float|string|Number|BCMathExtendedNumber $degrees)
    {
        return parent::__construct($degrees, self::MAX);
    }

    /**
     * Cast degrees to string.
     */
    public function __toString(): string
    {
        return $this->value->value . self::MEASURE;
    }
}