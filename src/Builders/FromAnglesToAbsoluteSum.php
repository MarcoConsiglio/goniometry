<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\Goniometry\Angle;
use RoundingMode;

class FromAnglesToAbsoluteSum extends SumBuilder
{
    /**
     * Construct the SumBuilder with two angles.
     * 
     * The sum will always be positive.
     *
     * @param Angle $first_angle
     * @param Angle $second_angle
     */
    public function __construct(Angle $first_angle, Angle $second_angle)
    {
        $this->first_angle = $first_angle;
        $this->second_angle = $second_angle;
    }

    /**
     * Fetch data to build an Angle which is the sum
     * between two angles.
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
        $this->calcSum();
        $seconds_decimal_places = Angle::countDecimalPlaces($this->seconds);
        return [
            $this->degrees,
            $this->minutes,
            $this->seconds,
            $this->direction,
            $seconds_decimal_places + 6, // Suggested decimal precision
            $this->decimal_sum, // Original decimal value
            $seconds_decimal_places, // Seconds precision
            null, // No original radian value 
            null  // No original radian precision
        ];
    }

    /**
     * Sum the two addend.
     *
     * @return void
     */
    protected function calcSum()
    {
        $this->calcSign();

        // These are shortcuts.
        if ($this->bothAnglesAreFullPositiveAngles()) {
            $this->degrees = Angle::MAX_DEGREES;
            return;
        }
        if ($this->bothAnglesAreNullAngles()) {
            return;
        }

        // Real calculation is performed here.
        $decimal_first_angle = $this->first_angle->toDecimal();
        $decimal_second_angle = $this->second_angle->toDecimal();
        $this->decimal_precision = $this->getMaxSuggestedDecimalPrecisionBetween($this->first_angle, $this->second_angle);
        $this->decimal_sum = round(
            $decimal_first_angle + $decimal_second_angle,
            $this->decimal_precision,
            RoundingMode::HalfTowardsZero
        );
        // Subtract any excess of 360°.
        $this->checkOverflow();
        // Calc the values of the sum angle.
        $this->calcDegrees();
        $this->calcMinutes();
        $this->calcSeconds();
    }

    /**
     * It calcs the result sign.
     * 
     * The sign/direction will be always positive/counterclockwise.
     *
     * @return void
     */
    protected function calcSign()
    {
        $this->direction = Angle::COUNTER_CLOCKWISE;
    }
}