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
        $this->degrees = abs($degrees);
        $this->minutes = abs($minutes);
        $this->seconds = round(abs($seconds), 1, RoundingMode::HalfTowardsZero);
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
        if ($this->valuesExceedsMaximumAllowed($this->degrees, $this->minutes, $this->seconds)) {
            throw new AngleOverflowException("The angle inputs can't be greater than 360° or 59' or 59.9\".");
        }
        $this->validateDirection();
    }

    /**
     * Validate the direction input.
     *
     * @return void
     */
    protected function validateDirection()
    {  
        $this->direction = $this->correctDirection($this->direction);
        if ($this->isNullAngle($this->degrees, $this->minutes, $this->seconds)) {
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
        return 
            $this->degreesExceeded($degrees) || 
            $this->minutesExceeded($minutes) || 
            $this->secondsExceeded($seconds);
    }

    /**
     * Check if degrees exceeds the maximum allowed value.
     *
     * @param integer $degrees
     * @return boolean
     */
    private function degreesExceeded(int $degrees): bool
    {
        return $degrees > Angle::MAX_DEGREES;
    }

    /**
     * Check if minutes exceeds the maximum allowed value.
     *
     * @param integer $minutes
     * @return boolean
     */
    private function minutesExceeded(int $minutes): bool
    {
        return $minutes >= Angle::MAX_MINUTES ;
    }

    private function secondsExceeded(float $seconds): bool
    {
        return $seconds >= Angle::MAX_SECONDS;
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