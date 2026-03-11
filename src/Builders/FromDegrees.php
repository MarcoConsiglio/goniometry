<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use Marcoconsiglio\ModularArithmetic\ModularNumber;

/**
 *  Builds an angle starting from degrees, minutes, seconds and direction.
 */
class FromDegrees extends AngleBuilder
{

    protected Number $degrees_input;

    protected Number $minutes_input;

    protected Number $seconds_input;

    protected Direction $direction_input;

    /**
     * Constructs and AngleBuilder with degrees, minutes, seconds and direction.
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
    protected function checkOverflow() 
    { 
        /*
         * No need to check overflow beacause
         * it is done in calcDegrees(), calcMinutes(),
         * calcSeconds().
         */
    }

    protected function calcDegrees() 
    {
        $this->degrees_input =
            $this->minutes_input->sub($this->minutes->value)
            ->div(Minutes::MAX)->plus($this->degrees_input);
        $this->degrees = new Degrees($this->degrees_input);
    }

    protected function calcMinutes() 
    {
        $this->minutes = new Minutes($this->minutes_input);
        $this->minutes_input = 
            $this->minutes_input->sub($this->minutes->value)
            ->div(Seconds::MAX)->plus($this->minutes_input);
        $this->minutes = new Minutes($this->minutes_input);
    }

    protected function calcSeconds() 
    {
        $this->seconds = new Seconds($this->seconds_input);
    }

    protected function calcSign() 
    {
        if ($this->isNullAngle())
            $this->direction = Direction::COUNTER_CLOCKWISE;
        else
            $this->direction = $this->direction_input;
    }

    private function isNullAngle(): bool
    {
        return 
            $this->hasZeroDegrees() &&
            $this->hasZeroMinutes() &&
            $this->hasZeroSeconds();
    }

    private function hasZeroDegrees(): bool
    {
        return $this->degrees->value->isEqual(0);
    }

    private function hasZeroMinutes(): bool
    {
        return $this->minutes->value->isEqual(0);
    }

    private function hasZeroSeconds(): bool
    {
        return $this->seconds->value->isEqual(0);
    }

    /**
     * Fetch data to build an Angle class.
     *
     * @return array{Degrees,Minutes,Seconds,Direction,null,null}
     */
    public function fetchData(): array
    {
        return [
            $this->degrees,
            $this->minutes,
            $this->seconds,
            $this->direction,
            null,
            null
        ];
    }
}