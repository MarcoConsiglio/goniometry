<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException;
use RoundingMode;

/**
 * Builds an angle starting from a decimal value.
 */
class FromDecimal extends AngleBuilder
{
    /**
     * The decimal value used to build an angle.
     *
     * @var float
     */
    protected float $decimal;

    /**
     * The number of decimal places of the decimal number
     * used to construct the builder.
     *
     * @var integer
     */
    protected int $decimal_precision;

    /**
     * The seconds precision.
     *
     * @var integer
     */
    protected int $seconds_precision;
    /**
     * The remainder that remains during the conversion steps from decimal to sexagesimal degrees.
     *
     * @var float
     */
    private float $reminder;

    /**
     * Constructs an AngleBuilder with a decimal value.
     *
     * @param float $decimal
     * @return void
     */
    public function __construct(float $decimal)
    {
        $this->decimal = $decimal;
        $this->calcDecimalPrecision($decimal);
        $this->checkOverflow();
    }

    /**
     * Check for overflow above/below +/-360°.
     *
     * @return void
     */
    protected function checkOverflow()
    {
        $this->validate($this->decimal);
    }

    /**
     * Check if values are valid.
     *
     * @param float $data
     * @return void
     */
    protected function validate(float $data)
    {
        if (abs($data) > Angle::MAX_DEGREES) {
            throw new AngleOverflowException("The angle can't be greather than 360°.");
        }
    }

    /**
     * Calc degrees.
     *
     * @return void
     */
    protected function calcDegrees()
    {
        $this->degrees = intval(abs($this->decimal));
        $this->reminder = abs($this->decimal) - $this->degrees;
    }

    /**
     * Calc minutes.
     *
     * @return void
     */
    protected function calcMinutes()
    {
        $this->minutes = intval($this->reminder * Angle::MAX_MINUTES);
        $this->reminder = abs($this->reminder - $this->minutes / Angle::MAX_MINUTES);
    }

    /**
     * Calc seconds.
     *
     * @return void
     */
    protected function calcSeconds()
    {
        $this->seconds_precision = $this->getSecondsPrecision();
        $this->seconds = round(
            $this->reminder * Angle::MAX_MINUTES * Angle::MAX_SECONDS,
            $this->seconds_precision, RoundingMode::HalfTowardsZero
        );
    }

    /**
     * Calc sign.
     *
     * @return void
     */
    protected function calcSign()
    {
        if ($this->decimal < 0) {
            $this->direction = Angle::CLOCKWISE;
        }
    }

    /**
     * Fetches the data to build an Angle.
     *
     * @return array{
     *      int,
     *      int,
     *      float,
     *      int,
     *      int|null,
     *      float|null,
     *      int|null,
     *      float|null,
     *      int|null
     *  }
     */
    public function fetchData(): array
    {
        $this->calcDegrees();
        $this->calcMinutes();
        $this->calcSeconds();
        $this->calcSign();
        return [
            $this->degrees,
            $this->minutes,
            $this->seconds,
            $this->direction,
            $this->decimal_precision, // Suggested decimal precision
            $this->decimal, // Original decimal value,
            $this->seconds_precision,
            null, // No original radian value
            null  // No original radian precision
        ];
    }

    /**
     * It calcs the number of decimal places
     * in $number.
     *
     * @param float $number
     * @return void
     */
    protected function calcDecimalPrecision(float $number)
    {
        $decimal_places = Angle::countDecimalPlaces($number);
        $this->decimal_precision = $decimal_places > PHP_FLOAT_DIG ? PHP_FLOAT_DIG : $decimal_places;
    }

    /**
     * It calcs the precision of seconds necessary to
     * correctly represents the seconds value of the Angle,
     * based on the original decimal precision passed to
     * this builder.
     *
     * @return integer
     */
    protected function getSecondsPrecision(): int
    {
        $precision = $this->decimal_precision + 6;
        if ($precision > PHP_FLOAT_DIG) return PHP_FLOAT_DIG;
        else return $precision;
    }
}