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
        if ($this->angleOverflows()) {
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
     * Check if one or more angle values exceeded the maximum allowed.
     *
     * @return bool
     */
    private function angleOverflows(): bool
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
    private function excessiveDegrees(): bool
    {
        return $this->degrees > Angle::MAX_DEGREES;
    }

    /**
     * Check if minutes exceeds Angle::MAX_MINUTES.
     * 
     * @return boolean
     */
    private function excessiveMinutes(): bool
    {
        return $this->minutes >= Angle::MAX_MINUTES ;
    }

    /**
     * Check if seconds exceeds Angle::MAX_SECONDS.
     *
     * @return boolean
     */
    private function excessiveSeconds(): bool
    {
        return $this->seconds >= Angle::MAX_SECONDS;
    }

    /**
     * Correct direction value in case of wrong integer input.
     *
     * @return int
     */
    private function correctDirection(): int
    {
        return $this->direction = $this->direction < 0 ? Angle::CLOCKWISE : Angle::COUNTER_CLOCKWISE;
    }

    /**
     * Check if the angle is a null angle.
     *
     * @return boolean
     */
    private function isNullAngle(): bool
    {
        return $this->degrees == 0 && $this->minutes == 0 && $this->seconds == 0;
    }
}