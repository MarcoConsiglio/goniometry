<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use Marcoconsiglio\ModularArithmetic\ModularNumber;

/**
 * Builds an angle starting from a decimal value.
 */
class FromDecimal extends AngleBuilder
{
    /**
     * The decimal value used to build an angle.
     */
    protected SexadecimalDegrees $decimal;

    /**
     * The remainder that remains during the conversion steps from decimal to
     * sexagesimal degrees.
     */
    private Number $reminder;

    /**
     * Constructs an `AngleBuilder` with a `$decimal` value.
     */
    public function __construct(float|SexadecimalDegrees $decimal)
    {
        if ($decimal instanceof SexadecimalDegrees) $this->decimal = $decimal;
        else $this->decimal = new SexadecimalDegrees($decimal);
    }

    /**
     * Check for overflow above/below +/-360°.
     * 
     * @codeCoverageIgnore
     */
    protected function checkOverflow(): void {/* No need to check overflow. Overflow is allowed. */}

    /**
     * Calc degrees.
     *
     * @return void
     */
    protected function calcDegrees(): void
    {
        $this->degrees = new Degrees($this->decimal->value->abs()->floor());
        $this->reminder = $this->decimal->value->abs()->sub($this->degrees->value);
    }

    /**
     * Calc minutes.
     *
     * @return void
     */
    protected function calcMinutes(): void
    {
        $this->minutes = new Minutes(
            $this->reminder->mul(Minutes::MAX)->floor()
        );
        $this->reminder = 
            $this->reminder
            ->mul(Minutes::MAX)
            ->sub($this->minutes->value);
    }

    /**
     * Calc seconds.
     *
     * @return void
     */
    protected function calcSeconds(): void
    {
        $this->seconds = new Seconds(
            $this->reminder->mul(Seconds::MAX)
        );
    }

    /**
     * Calc sign.s
     *
     * @return void
     */
    protected function calcSign(): void
    {
        $this->direction = 
            $this->decimal->value->isPositive() ?
            Direction::COUNTER_CLOCKWISE :
            Direction::CLOCKWISE;
    }

    /**
     * Fetches the data to build an Angle.
     *
     * @return array{Degrees,Minutes,Seconds,Direction,SexadecimalDegrees,null}
     */
    public function fetchData(): array
    {
        $this->calcDegrees();
        $this->calcMinutes();
        $this->calcSeconds();
        $this->calcSign();
        return [
            $this->degrees,
            $this->minutes,
            $this->seconds,
            $this->direction,
            $this->decimal,
            null
        ];
    }
}