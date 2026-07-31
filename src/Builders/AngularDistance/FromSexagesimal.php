<?php
namespace MarcoConsiglio\Goniometry\Builders\AngularDistance;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Builders\Builder;
use MarcoConsiglio\Goniometry\Builders\Traits\CalcOrderForSexagesimals;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use MarcoConsiglio\ModularArithmetic\ModularRelativeNumber;

/**
 *  Build an `AngularDistance` starting from sexagesimal values.
 * 
 * @internal
 */
class FromSexagesimal extends Builder
{
    use CalcOrderForSexagesimals;

    protected Number $degrees_input;

    protected Number $minutes_input;

    protected Number $seconds_input;

    protected Number $reminder;

    protected Rotation $direction;

    protected SexadecimalAngularDistance $sexadecimal;

    protected bool $is_sexadecimal_positive;

    /**
     * Constructs and `AngleBuilder` with sexagesimal `$degrees`, `$minutes`, `$seconds`
     * and `$direction`.
     */
    public function __construct(
        int $degrees, 
        int $minutes, 
        float $seconds, 
        protected Rotation $direction_input = Rotation::COUNTER_CLOCKWISE
    ) {
        $this->degrees_input = new Number(abs($degrees));
        $this->minutes_input = new Number(abs($minutes));
        $this->seconds_input = new Number(abs($seconds));
        $decimal = $this->seconds_input->div(Minutes::MAX * Seconds::MAX);
        $decimal = $decimal->plus($this->minutes_input->div(Minutes::MAX));
        $decimal = $decimal->plus($this->degrees_input);
        $decimal = $decimal->mul($this->direction_input->value);
        $this->sexadecimal = new SexadecimalAngularDistance($decimal);
        $this->is_sexadecimal_positive = $this->sexadecimal->value->isPositive();
    }

    /**
     * Calc sexagesimal degrees.
     */
    protected function calcDegrees(): void 
    {
        $degrees = 
            $this->is_sexadecimal_positive ?
            $this->sexadecimal->value->floor()->abs() :
            $this->sexadecimal->value->ceil()->abs();
        $this->degrees = new Degrees($degrees);
        $this->reminder = 
            $this->is_sexadecimal_positive ?
            $this->sexadecimal->value->sub($degrees) :
            $this->sexadecimal->value->plus($degrees);
    }

    /**
     * Calc sexagesimal minutes.
     */
    protected function calcMinutes(): void 
    {
        $minutes = $this->reminder->abs()->mul(Minutes::MAX)->floor();
        $this->minutes = new Minutes($minutes);
        $this->reminder = 
            $this->is_sexadecimal_positive ?
            $this->reminder->sub($minutes->div(Minutes::MAX)) :
            $this->reminder->plus($minutes->div(Minutes::MAX));
    }

    /**
     * Calc sexagesimal seconds.
     */
    protected function calcSeconds(): void 
    {
        $this->seconds = new Seconds(
            $this->reminder->abs()->mul(Minutes::MAX * Seconds::MAX)
        );
    }

    /**
     * Calc the `Angle`'s direction.
     */
    protected function calcSign(): void 
    {
        if ($this->isNullAngle())
            $this->direction = Rotation::COUNTER_CLOCKWISE;
        else
            $this->sexadecimal->value->isPositive() ?
            $this->direction = Rotation::COUNTER_CLOCKWISE :
            $this->direction = Rotation::CLOCKWISE;
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
     * @return array{SexagesimalDegrees,SexadecimalAngularDistance,null}
     */
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
            null, // Sexadecimal
            null  // Radian
        ];
    }
}