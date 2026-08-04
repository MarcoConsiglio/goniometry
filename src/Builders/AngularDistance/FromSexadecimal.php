<?php
namespace MarcoConsiglio\Goniometry\Builders\AngularDistance;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Builders\Builder;
use MarcoConsiglio\Goniometry\Builders\Traits\CalcOrderForSexagesimals;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use Override;

/**
 *  Build an `AngularDistance` starting from a sexadecimal value.
 * 
 * @internal
 */
class FromSexadecimal extends Builder
{
    use CalcOrderForSexagesimals;

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
     * Construct `FromSexadecimal` `AngleBuilder` with a sexadecimal angular distance value.
     */
    public function __construct(float|SexadecimalAngularDistance $decimal)
    {
        $this->decimal =
            $decimal instanceof SexadecimalAngularDistance ?
            $decimal : new SexadecimalAngularDistance($decimal);
    }

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
            Rotation::COUNTER_CLOCKWISE :
            Rotation::CLOCKWISE;
    }

    /**
     * Fetches the data to build an `AngularDistance`.
     * 
     * @return array{SexagesimalDegrees,SexadecimalAngularDistance,null}
     */
    #[Override]
    public function fetchData(): array
    {
        $this->calcFromMostToLessSignificantValue();
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