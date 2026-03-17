<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;

/**
 *  Builds an `Angle` starting from degrees, minutes, seconds and direction.
 */
class FromSexagesimal extends AngleBuilder
{

    protected Number $degrees_input;

    protected Number $minutes_input;

    protected Number $seconds_input;

    protected Direction $direction_input;

    /**
     * Constructs and `AngleBuilder` with degrees, minutes, seconds and direction.
     */
    public function __construct(int $degrees, int $minutes, float $seconds, Direction $direction = Direction::COUNTER_CLOCKWISE)
    {
        $this->degrees_input = new Number(abs($degrees));
        $this->minutes_input = new Number(abs($minutes));
        $this->seconds_input = new Number(abs($seconds));
        $this->direction_input = $direction;
        $this->calcSeconds();
        $this->calcMinutes();
        $this->calcDegrees();
        $this->calcSign();
    }

    /**
     * Check for overflow above/below +/-360°.
     * 
     * @codeCoverageIgnore
     */
    protected function checkOverflow(): void 
    { 
        /*
         * No need to check overflow beacause
         * it is done in calcDegrees(), calcMinutes(),
         * calcSeconds().
         */
    }

    /**
     * Calc sexagesimal degrees.
     */
    protected function calcDegrees(): void 
    {
        $this->degrees_input =
            $this->minutes_input->sub($this->minutes->value)
            ->div(Minutes::MAX)->plus($this->degrees_input);
        $this->degrees = new Degrees($this->degrees_input);
    }

    /**
     * Calc sexagesimal minutes.
     */
    protected function calcMinutes(): void 
    {
        $this->minutes = new Minutes($this->minutes_input);
        $this->minutes_input = 
            $this->minutes_input->sub($this->minutes->value)
            ->div(Seconds::MAX)->plus($this->minutes_input);
        $this->minutes = new Minutes($this->minutes_input);
    }

    /**
     * Calc sexagesimal seconds.
     */
    protected function calcSeconds(): void 
    {
        $this->seconds = new Seconds($this->seconds_input);
    }

    /**
     * Calc the `Angle`'s direction.
     */
    protected function calcSign(): void 
    {
        if ($this->isNullAngle())
            $this->direction = Direction::COUNTER_CLOCKWISE;
        else
            $this->direction = $this->direction_input;
    }

    /**
     * Return true if the sexagesimal values are 
     * all zero, false otherwise.
     * 
     * @codeCoverageIgnore
     */
    private function isNullAngle(): bool
    {
        return 
            $this->hasZeroDegrees() &&
            $this->hasZeroMinutes() &&
            $this->hasZeroSeconds();
    }

    /**
     * Return true if degrees are zero, false otherwise.
     */
    private function hasZeroDegrees(): bool
    {
        return $this->degrees->value->isEqual(0);
    }

    /**
     * Return true if minutes are zero, false otherwise.
     */
    private function hasZeroMinutes(): bool
    {
        return $this->minutes->value->isEqual(0);
    }

    /**
     * Return true if seconds are zero, false otherwise.
     */
    private function hasZeroSeconds(): bool
    {
        return $this->seconds->value->isEqual(0);
    }

    /**
     * Fetch data to build an Angle class.
     *
     * @return array{SexagesimalDegrees,null,null}
     */
    public function fetchData(): array
    {
        return [
            new SexagesimalDegrees(
                $this->degrees,
                $this->minutes,
                $this->seconds,
                $this->direction
            ),
            null,
            null
        ];
    }
}