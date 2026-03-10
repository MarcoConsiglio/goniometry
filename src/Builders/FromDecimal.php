<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use Marcoconsiglio\ModularArithmetic\ModularNumber;
use RoundingMode;

/**
 * Builds an angle starting from a decimal value.
 */
class FromDecimal extends AngleBuilder
{
    /**
     * The decimal value used to build an angle.
     */
    protected ModularNumber $decimal;

    /**
     * The decimal value input.
     */
    protected float $decimal_input;

    /**
     * The remainder that remains during the conversion steps from decimal to
     * sexagesimal degrees.
     */
    private Number $reminder;

    /**
     * Constructs an AngleBuilder with a $decimal value.
     */
    public function __construct(float $decimal)
    {
        $this->decimal_input = $decimal;
        $this->decimal = new ModularNumber(abs($decimal), Angle::MAX_DEGREES);
    }

    /**
     * Check for overflow above/below +/-360°.
     */
    protected function checkOverflow() {/* No need to check overflow. Overflow is allowed. */}

    /**
     * Calc degrees.
     *
     * @return void
     */
    protected function calcDegrees()
    {
        $this->degrees = new Degrees($this->decimal->floor()->value);
        $this->reminder = $this->decimal->value->sub($this->degrees->value);
    }

    /**
     * Calc minutes.
     *
     * @return void
     */
    protected function calcMinutes()
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
    protected function calcSeconds()
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
    protected function calcSign()
    {
        $this->direction = 
            $this->decimal_input >= 0 ?
            Direction::COUNTER_CLOCKWISE :
            Direction::CLOCKWISE;
    }

    /**
     * Fetches the data to build an Angle.
     *
     * @return array{Degrees,Minutes,Seconds,Direction,float,null}
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
            $this->decimal_input,
            null
        ];
    }
}