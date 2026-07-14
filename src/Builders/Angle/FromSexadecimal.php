<?php
namespace MarcoConsiglio\Goniometry\Builders\Angle;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;

/**
 * Build an `Angle` starting from a sexadecimal value.
 * 
 * @internal
 */
class FromSexadecimal extends AngleBuilder
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
     * Construct `FromSexadecimal` `AngleBuilder` with a sexadecimal degrees value.
     */
    public function __construct(float|SexadecimalDegrees $decimal)
    {
        $this->decimal =
            $decimal instanceof SexadecimalDegrees ?
            $decimal : new SexadecimalDegrees($decimal);
    }

    /**
     * Not implemented as overflow above/below +/-360° is allowed.
     * 
     * @codeCoverageIgnore
     */
    protected function checkOverflow(): void {/* No need to check overflow. Overflow is allowed. */}

    /**
     * Calc degrees.
     */
    protected function calcDegrees(): void
    {
        $this->degrees = new Degrees($this->decimal->value->abs()->floor());
        $this->reminder = $this->decimal->value->abs()->sub($this->degrees->value);
    }

    /**
     * Calc minutes.
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
     */
    protected function calcSeconds(): void
    {
        $this->seconds = new Seconds(
            $this->reminder->mul(Seconds::MAX)
        );
    }

    /**
     * Calc sign.
     */
    protected function calcSign(): void
    {
        $this->direction = 
            $this->decimal->value->isPositive() ?
            Rotation::COUNTER_CLOCKWISE :
            Rotation::CLOCKWISE;
    }

    /**
     * Fetches the data to build an `Angle`.
     *
     * @return array{SexagesimalDegrees,SexadecimalDegrees,null}
     */
    public function fetchData(): array
    {
        $this->calcDegrees();
        $this->calcMinutes();
        $this->calcSeconds();
        $this->calcSign();
        return [
            new SexagesimalDegrees(
                $this->degrees,
                $this->minutes,
                $this->seconds,
                $this->direction
            ),
            $this->decimal,
            null
        ];
    }
}