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
 * Sum two angles resulting in a relative sum.
 */
class FromAnglesToRelativeSum extends SumBuilder
{
    protected Number $alfa_degrees;

    protected Number $alfa_minutes;

    protected Number $alfa_seconds;

    protected Number $beta_degrees;

    protected Number $beta_minutes;

    protected Number $beta_seconds;

    public function __construct(Angle $alfa, Angle $beta)
    {
        parent::__construct($alfa, $beta);
        $this->alfa_degrees = $alfa->degrees->value;
        $this->alfa_minutes = $alfa->minutes->value;
        $this->alfa_seconds = $alfa->seconds->value;
        $this->beta_degrees = $beta->degrees->value;
        $this->beta_minutes = $beta->minutes->value;
        $this->beta_seconds = $beta->seconds->value;
    }

    /**
     * It calcs the result sign.
     *
     * @return void
     */
    protected function calcSign()
    {
        $this->operation =
            $this->alfa->direction == $this->beta->direction ?
            $this->alfa->direction : 
            $this->alfa->direction->opposite();
    }

    /**
     * Sum the two addend.
     *
     * @return void
     */
    protected function calcSum()
    {
        $this->calcSign();
        $this->calcSeconds();
        $this->calcMinutes();
        $this->calcDegrees();
    }

    private function subSeconds(): void
    {
        if ($this->needBorrowing($this->alfa_seconds, $this->beta_seconds))
            $this->borrow($this->alfa_minutes, $this->alfa_seconds);
        $this->seconds = new Seconds(
            $this->alfa_seconds->sub($this->beta_seconds)
        );
    }

    private function subMinutes(): void
    {
        if ($this->needBorrowing($this->alfa_minutes, $this->beta_minutes))
            $this->borrow($this->alfa_degrees, $this->alfa_minutes);
        $this->minutes = new Minutes(
            $this->alfa_minutes->sub($this->beta_minutes)
        );
    }

    private function subDegrees(): void
    {
        if ($this->needBorrowing($this->alfa_minutes, $this->beta_minutes))
            $this->borrow($this->alfa_degrees, $this->alfa_minutes);
        $degrees = $this->alfa_degrees->sub($this->beta_degrees);
        $this->setSign($degrees);
        $this->degrees = new Degrees(
            $degrees->abs()
        );
    }

    private function addSeconds(Number &$reminder): void
    {
        $seconds = $this->alfa_seconds->add($this->beta_seconds);
        $this->seconds = new ModularNumber($seconds, Seconds::MAX);
        $reminder = new Number(
            $seconds->sub($this->seconds->value)->div(Seconds::MAX)
        );
    }

    private function addMinutes(Number &$reminder): void
    {
        $minutes = $this->alfa_minutes->add($this->beta_minutes)->add($reminder);
        $this->minutes = new ModularNumber($minutes, Minutes::MAX);
        $reminder = new Number(
            $minutes->sub($this->minutes->value)->div(Minutes::MAX)
        );
    }

    private function addDegrees(Number &$reminder): void
    {
        $degrees = $this->alfa_degrees->add($this->beta_degrees)->add($reminder);
        $this->degrees = new ModularNumber($degrees, Degrees::MAX);
    }

    private function needBorrowing(Number $first_number, Number $second_number): bool
    {
        return $first_number->lt($second_number->value);
    }

    private function borrow(Number &$from, Number &$to): void
    {
        $from = $from->sub(1);
        $to = $to->add(60);
    }

    private function setSign(Number $degrees_result): void
    {
        if ($degrees_result->isPositive())
            $this->direction = Direction::CLOCKWISE;
        else
            $this->direction = Direction::COUNTER_CLOCKWISE;
    }

    /**
     * Fetch data to build an Angle which is the sum
     * between two angles.
     *
     * @return array{Degrees,Minutes,Seconds,Direction}
     */
    public function fetchData(): array
    {
        $this->calcSum();
        return [
            $this->degrees,
            $this->minutes,
            $this->seconds,
            $this->direction
        ];
    }

    protected function calcSeconds()
    {
        if ($this->operation == Direction::COUNTER_CLOCKWISE)
            $this->addSeconds($this->reminder);
        else
            $this->subSeconds();
    }

    protected function calcMinutes()
    {
        if ($this->operation == Direction::COUNTER_CLOCKWISE)
            $this->addMinutes($this->reminder);
        else
            $this->subMinutes();
    }

    protected function calcDegrees()
    {
        if ($this->operation == Direction::COUNTER_CLOCKWISE)
            $this->addDegrees($this->reminder);
        else
            $this->subDegrees();
    }

    /**
     * @codeCoverageIgnore
     */
    protected function checkOverflow() {/* There's no need to check overflow */}
}