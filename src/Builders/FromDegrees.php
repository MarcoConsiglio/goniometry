<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException;
use RoundingMode;

/**
 *  Builds an angle starting from degrees, minutes and seconds.
 */
class FromDegrees extends AngleBuilder
{
    /**
     * Constructs and AngleBuilder with degrees, minutes, seconds and direction.
     *
     * @param integer $degrees
     * @param integer $minutes
     * @param float $seconds
     * @param integer $direction
     * @return void
     */
    public function __construct(int $degrees, int $minutes, float $seconds, int $direction = Angle::COUNTER_CLOCKWISE)
    {
        $this->degrees = $degrees;
        $this->minutes = $minutes;
        $this->seconds = $seconds;
        $this->direction = $direction;
        $this->checkOverflow();
    }

    /**
     * Check for overflow above/below +/-360°.
     *
     * @return void
     * @throws \MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException when angle values exceeds.
     */
    public function checkOverflow()
    {
        $this->validate(
            $this->degrees,
            $this->minutes,
            $this->seconds,
            $this->direction
        );
    }

    /**
     * Check if values are valid.
     *
     * @param integer $degrees
     * @param integer $minutes
     * @param float   $seconds
     * @param int     $direction
     * @return boolean
     */
    protected function validate(int $degrees, int $minutes, float $seconds, int $direction)
    {  
        if ($this->valuesExceedsMaximumAllowed($degrees, $minutes, $seconds)) {
            throw new AngleOverflowException("The angle inputs can't be greater than 360° or 59' or 59.9\".");
        }
        $this->direction = $this->correctDirection($direction);
        if ($this->isNullAngle($degrees, $minutes, $seconds)) {
            $this->direction = Angle::COUNTER_CLOCKWISE;
        }
    }

    /**
     * Calc degrees.
     * 
     * @return void
     * @codeCoverageIgnore
     */
    public function calcDegrees()
    {

    }

    /**
     * Calc minutes.
     *
     * @return void
     * @codeCoverageIgnore
     */
    public function calcMinutes()
    {

    }

    /**
     * Calc seconds.
     *
     * @return void
     * @codeCoverageIgnore
     */
    public function calcSeconds()
    {

    }

    /**
     * Calc sign.
     *
     * @param mixed $data
     * @return void
     * @codeCoverageIgnore
     */
    public function calcSign()
    {

    }

    /**
     * Check if one or more of angle values exceeded the maximum allowed.
     *
     * @param integer $degrees
     * @param integer $minutes
     * @param float $seconds
     * @return void
     */
    private function valuesExceedsMaximumAllowed(int $degrees, int $minutes, float $seconds)
    {
        $exceeds_degrees = $degrees > Angle::MAX_DEGREES;
        $exceeds_minutes = $minutes > Angle::MAX_MINUTES - 1;
        $exceeds_seconds = $seconds > round(Angle::MAX_SECONDS - 0.1, 1, RoundingMode::HalfTowardsZero);
        return $exceeds_degrees || $exceeds_minutes || $exceeds_seconds;
    }

    /**
     * Correct direction value in case of wrong integer input.
     *
     * @param integer $direction
     * @return int
     */
    private function correctDirection(int $direction): int
    {
        return $direction < 0 ? Angle::CLOCKWISE : Angle::COUNTER_CLOCKWISE;
    }

    /**
     * Check if the angle is a null angle.
     *
     * @param integer $degrees
     * @param integer $minutes
     * @param float $seconds
     * @return boolean
     */
    private function isNullAngle(int $degrees, int $minutes, float $seconds): bool
    {
        return $degrees == 0 && $minutes == 0 && $seconds == 0;
    }
}