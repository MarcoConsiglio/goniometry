<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\Goniometry\Angle;
use RoundingMode;

/**
 * Represents a sum builder.
 */
abstract class SumBuilder extends AngleBuilder
{
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
     * Construct the SumBuilder with two angles.
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
     * It checks for overflow above/below ±360°.
     *
     * @return void
     */
    protected function checkOverflow()
    {
        $this->decimal_sum = round(
            fmod($this->decimal_sum + Angle::MAX_DEGREES, Angle::MAX_DEGREES),
            $this->decimal_precision,
            RoundingMode::HalfTowardsZero
        );
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
}