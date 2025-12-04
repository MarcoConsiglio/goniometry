<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\Goniometry\Angle;
use RoundingMode;

/**
 * Sums two angles.
 */
class FromAngles extends SumBuilder
{
    /**
     * The decimal sum of the two angles.
     * 
     * @var float
     */
    protected float $decimal_sum = 0.0;

    /**
     * The reminder used in calculations.
     *
     * @var float
     */
    protected float $reminder = 0.0;

    /**
     * The precision of the decimal value used
     * int the sum calculation.
     * 
     * @var integer
     */
    protected int $decimal_precision = 0;

    /**
     * The first addend.
     *
     * @var Angle
     */
    protected Angle $first_angle;

    /**
     * The second addend.
     *
     * @var Angle
     */
    protected Angle $second_angle;

    /**
     * It construct the SumBuilder with two angles.
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
     * It checks for overflow above/below ±360°.
     *
     * @return void
     */
    protected function checkOverflow()
    {
        $this->decimal_sum = round(
            fmod($this->decimal_sum, Angle::MAX_DEGREES),
            $this->decimal_precision,
            RoundingMode::HalfTowardsZero
        );
    }

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
        // This are shortcuts.
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
     * It checks that both angle operands are positive full angles.
     *
     * @return boolean
     */  
    protected function bothAnglesAreFullPositiveAngles(): bool
    {
        return 
            $this->isFullAngle($this->first_angle, Angle::COUNTER_CLOCKWISE) && 
            $this->isFullAngle($this->second_angle, Angle::COUNTER_CLOCKWISE);
    }

    /**
     * It checks that both angle operands are negative full angles.
     *
     * @return boolean
     */  
    protected function bothAnglesAreFullNegativeAngles(): bool
    {
        return 
            $this->isFullAngle($this->first_angle, Angle::CLOCKWISE) && 
            $this->isFullAngle($this->second_angle, Angle::CLOCKWISE);
    }

    /**
     * It checks that both angle operands are null angles.
     *
     * @return boolean
     */
    protected function bothAnglesAreNullAngles(): bool
    {
        return $this->isNullAngle($this->first_angle) && $this->isNullAngle($this->second_angle);
    }

    /**
     * It checks that an $angle is a full angle.
     *
     * @param Angle $angle
     * @param int $sign The expected sign of the angle being checked.
     * @return boolean
     */
    protected function isFullAngle(Angle $angle, int $sign): bool
    {
        $sign = $sign >= 0 ? Angle::COUNTER_CLOCKWISE : Angle::CLOCKWISE;
        return $angle->direction == $sign && $angle->isEqual(Angle::MAX_DEGREES) ;
    }

    /**
     * It checks that an $angle is a null angle.
     *
     * @param Angle $angle
     * @return boolean
     */
    protected function isNullAngle(Angle $angle): bool
    {
        return $angle->isEqual(0);
    }

    /**
     * It calcs seconds value.
     *
     * @return void
     */
    protected function calcSeconds()
    {
        $this->seconds = round(
            $this->reminder * Angle::MAX_SECONDS,
            $this->decimal_precision - 2,
            RoundingMode::HalfTowardsZero
        );
    }

    /**
     * It calcs minutes value.    
     *
     * @return void
     */
    protected function calcMinutes()
    {
        $this->reminder = abs($this->decimal_sum) - $this->degrees;
        $this->reminder *= Angle::MAX_MINUTES;
        $this->minutes = intval($this->reminder);
        $this->reminder -= $this->minutes;
    }

    /**
     * It calcs degrees value.
     *
     * @return void
     */
    protected function calcDegrees()
    {
        $this->degrees = intval(abs($this->decimal_sum));
    }

    /**
     * Get the max suggested decimal precision between two angles.
     *
     * @param Angle $first
     * @param Angle $second
     * @return integer
     */
    protected function getMaxSuggestedDecimalPrecisionBetween(Angle $first, Angle $second): int
    {
        return max(
            $first->suggested_decimal_precision,
            $second->suggested_decimal_precision
        );
    }

    /**
     * Fetch data to build a Sum class.
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
}