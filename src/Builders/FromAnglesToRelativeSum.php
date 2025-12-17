<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\Goniometry\Angle;
use RoundingMode;

/**
 * Sum two angles resulting in a relative sum.
 */
class FromAnglesToRelativeSum extends SumBuilder
{
    /**
     * It calcs the result sign.
     *
     * @return void
     */
    protected function calcSign()
    {
        $this->direction = $this->decimal_sum >= 0 ? Angle::COUNTER_CLOCKWISE : Angle::CLOCKWISE;
    }

    /**
     * Sum the two addend.
     *
     * @return void
     */
    protected function calcSum()
    {
        // These are shortcuts.
        if ($this->bothAnglesAreFullPositiveAngles()) {
            $this->degrees = Angle::MAX_DEGREES;
            return;
        }
        if ($this->bothAnglesAreFullNegativeAngles()) {
            $this->degrees = Angle::MAX_DEGREES;
            $this->direction = Angle::CLOCKWISE;
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
        // Calc the sign of the algebraic sum and return the absolute result.
        $this->calcSign();
        // Subtract any excess of 360°.
        $this->checkOverflow();
        // Calc the values of the sum angle.
        $this->calcDegrees();
        $this->calcMinutes();
        $this->calcSeconds();
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
            $this->decimal_precision, // Suggested decimal precision
            $this->decimal_sum, // Original decimal value
            $seconds_decimal_places, // Seconds precision
            null, // No original radian value 
            null  // No original radian precision
        ];
    }
}