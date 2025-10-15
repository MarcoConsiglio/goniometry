<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;
use RoundingMode;

/**
 * Sums two angles.
 */
class FromAngles extends SumBuilder
{
    /**
     * Temporary seconds variable.
     * 
     * @var float
     */
    protected $temp_seconds = 0.0;

    /**
     * Temporary minutes variable.
     * 
     * @var int
     */
    protected $temp_minutes = 0;

    /**
     * Temporary degrees variable.
     * 
     * @var int
     */
    protected $temp_degrees = 0;

    /**
     * The first addend.
     *
     * @var \MarcoConsiglio\Goniometry\Interfaces\Angle
     */
    protected AngleInterface $first_angle;

    /**
     * The second addend.
     *
     * @var \MarcoConsiglio\Goniometry\Interfaces\Angle
     */
    protected AngleInterface $second_angle;

    /**
     * Constructs a SumBuilder builder with two angles.
     *
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $first_angle
     * @param \MarcoConsiglio\Goniometry\Interfaces\Angle $second_angle
     */
    public function __construct(AngleInterface $first_angle, AngleInterface $second_angle)
    {
        $this->first_angle = $first_angle;
        $this->second_angle = $second_angle;
    }

    /**
     * Check for overflow above/below +/-360°.
     *
     * @return void
     */
    protected function checkOverflow()
    {
        $full_angle = Angle::MAX_DEGREES * Angle::MAX_MINUTES * Angle::MAX_SECONDS;
        while ($this->angleOverflows()) {
            $this->temp_seconds = round($this->temp_seconds - $full_angle, 3, RoundingMode::HalfTowardsZero);
        }
    }

    /**
     * Check if the angle overflows.
     *
     * @return boolean
     */
    protected function angleOverflows(): bool
    {
        return $this->temp_seconds > Angle::MAX_DEGREES * Angle::MAX_MINUTES * Angle::MAX_SECONDS;
    }

    /**
     * Calcs degrees.
     *
     * @return void
     */
    protected function calcDegrees()
    {
      $this->degrees = $this->temp_degrees;
    }

    /**
     * Calc minutes.    
     *
     * @return void
     */
    protected function calcMinutes()
    {
        while ($this->excessiveMinutes()) {
            $this->temp_minutes -= Angle::MAX_MINUTES;
            $this->temp_degrees++;
        }
        $this->minutes = $this->temp_minutes;
    }

    /**
     * Check if minutes exceeds Angle::MAX_MINUTES.
     *
     * @return bool
     */
    protected function excessiveMinutes(): bool
    {
        return $this->temp_minutes >= Angle::MAX_MINUTES;
    }

    /**
     * Calc seconds.
     *
     * @return void
     */
    protected function calcSeconds()
    {
        while ($this->excessiveSeconds()) {
            $this->temp_seconds = round($this->temp_seconds - Angle::MAX_SECONDS, 3, RoundingMode::HalfTowardsZero);
            $this->temp_minutes++;
        }
        $this->seconds = $this->temp_seconds;
    }

    /**
     * Check if seconds exceeds Angle::MAX_SECONDS.
     *
     * @return boolean
     */
    protected function excessiveSeconds(): bool
    {
        return $this->temp_seconds >= Angle::MAX_SECONDS;
    }

    /**
     * Calc sign.
     *
     * @return void
     */
    protected function calcSign()
    {
        $this->direction = $this->temp_seconds >= 0 ? Angle::COUNTER_CLOCKWISE : Angle::CLOCKWISE;
        $this->temp_seconds = abs($this->temp_seconds);
    }

    /**
     * Sum the two addend.
     *
     * @return void
     */
    protected function calcSum()
    {
        // Transform first angle in seconds.
        $first_angle_total_seconds = Angle::toTotalSeconds($this->first_angle);
        // Calc the sign of the first angle.
        $first_angle_total_seconds = $first_angle_total_seconds * $this->first_angle->direction;
        // Transform second angle in seconds.
        $second_angle_total_seconds = Angle::toTotalSeconds($this->second_angle);
        // Calc the sign of the second angle.
        $second_angle_total_seconds = $second_angle_total_seconds * $this->second_angle->direction;
        // Calc the algebraic sum in seconds.
        $this->temp_seconds = round($first_angle_total_seconds + $second_angle_total_seconds, 3);
        // Calc the sign of the algebraic sum.
        $this->calcSign();
        // Subtract any excess of 360°.
        $this->checkOverflow();
        // Calc the values of the sum angle.
        $this->calcSeconds();
        $this->calcMinutes();
        $this->calcDegrees();
    }



    /**
     * Fetch data to build a Sum class.
     *
     * @return array
     */
    public function fetchData(): array
    {
        $this->calcSum();
        return parent::fetchData();
    }
}