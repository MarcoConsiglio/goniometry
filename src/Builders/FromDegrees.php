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
        $this->validateDirection();
    }

    /**
     * Check for overflow above/below +/-360°.
     *
     * @return void
     * @throws \MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException when angle values exceeds.
     */
    protected function checkOverflow()
    {
        if ($this->angleOverflows()) {
            throw new AngleOverflowException("The angle inputs can't be greater than 360° or 59' or 59.9\".");
        }
    }

    /**
     * Validate the direction input.
     *
     * @return void
     */
    protected function validateDirection()
    {  
        $this->correctDirection();
        if ($this->isNullAngle()) {
            $this->direction = Angle::COUNTER_CLOCKWISE;
        }
    }

    /**
     * Calc degrees.
     * 
     * @return void
     * @codeCoverageIgnore
     */
    protected function calcDegrees()
    {

    }

    /**
     * Calc minutes.
     *
     * @return void
     * @codeCoverageIgnore
     */
    protected function calcMinutes()
    {

    }

    /**
     * Calc seconds.
     *
     * @return void
     * @codeCoverageIgnore
     */
    protected function calcSeconds()
    {

    }

    /**
     * Calc sign.
     *
     * @param mixed $data
     * @return void
     * @codeCoverageIgnore
     */
    protected function calcSign()
    {

    }

    /**
     * Check if one or more angle values exceeded the maximum allowed.
     *
     * @return bool
     */
    protected function angleOverflows(): bool
    {
        return 
            $this->excessiveDegrees() || 
            $this->excessiveMinutes() || 
            $this->excessiveSeconds();
    }

    /**
     * Check if degrees exceeds Angle::MAX_DEGREES.
     *
     * @return boolean
     */
    protected function excessiveDegrees(): bool
    {
        return $this->degrees > Angle::MAX_DEGREES;
    }

    /**
     * Check if minutes exceeds Angle::MAX_MINUTES.
     * 
     * @return boolean
     */
    protected function excessiveMinutes(): bool
    {
        return $this->minutes >= Angle::MAX_MINUTES ;
    }

    /**
     * Check if seconds exceeds Angle::MAX_SECONDS.
     *
     * @return boolean
     */
    protected function excessiveSeconds(): bool
    {
        return $this->seconds >= Angle::MAX_SECONDS;
    }

    /**
     * Correct direction value in case of wrong integer input.
     *
     * @return int
     */
    protected function correctDirection(): int
    {
        return $this->direction = $this->direction < 0 ? Angle::CLOCKWISE : Angle::COUNTER_CLOCKWISE;
    }

    /**
     * Check if the angle is a null angle.
     *
     * @return boolean
     */
    protected function isNullAngle(): bool
    {
        return $this->zeroDegrees() && $this->zeroMinutes() && $this->zeroSeconds();
    }

    /**
     * Check if degrees are zero.
     *
     * @return boolean
     */
    protected function zeroDegrees(): bool
    {
        return $this->degrees == 0;
    }
    
    /**
     * Check if minutes are zero.
     *
     * @return boolean
     */
    protected function zeroMinutes(): bool
    {
        return $this->minutes == 0;
    }

    /**
     * Check if seconds are zero.
     *
     * @return boolean
     */
    protected function zeroSeconds(): bool
    {
        return $this->seconds == 0;
    }
}