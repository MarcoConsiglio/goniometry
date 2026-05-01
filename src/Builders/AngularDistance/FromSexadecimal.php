<?php
namespace MarcoConsiglio\Goniometry\Builders\AngularDistance;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Builders\Angle\AngleBuilder;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use Override;

class FromSexadecimal extends AngleBuilder
{
    /**
     * The decimal value used to build an angular distance.
     */
    protected SexadecimalAngularDistance $decimal;

    /**
     * The remainder that remains during the conversion steps from decimal to
     * sexagesimal degrees.
     */
    private Number $reminder;

    /**
     * Construct an `AngleBuilder`with from a sexadecimal angular distance value.
     */
    public function __construct(float|SexadecimalAngularDistance $decimal)
    {
        $this->decimal =
            $decimal instanceof SexadecimalAngularDistance ?
            $decimal : new SexadecimalAngularDistance($decimal);
    }


    /**
     * Check for overflow above/below +/-360°.
     * 
     * @codeCoverageIgnore
     */
    #[Override]
    protected function checkOverflow(): void {/* No need to check overflow. Overflow is allowed. */}


    /**
     * Calc degrees.
     */
    #[Override]
    protected function calcDegrees(): void
    {
        $this->degrees = new Degrees($this->decimal->value->abs()->floor());
        $this->reminder = $this->decimal->value->abs()->sub($this->degrees->value);
    }

    /**
     * Calc minutes.
     */
    #[Override]
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
    #[Override]
    protected function calcSeconds(): void
    {
        $this->seconds = new Seconds(
            $this->reminder->mul(Seconds::MAX)
        );
    }

    /**
     * Calc sign.
     */
    #[Override]
    protected function calcSign(): void
    {
        $this->direction = 
            $this->decimal->value->isPositive() ?
            Direction::COUNTER_CLOCKWISE :
            Direction::CLOCKWISE;
    }

    /**
     * Fetches the data to build an `AngularDistance`.
     * 
     * @return array{SexagesimalDegrees,SexadecimalAngularDistance,null}
     */
    #[Override]
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