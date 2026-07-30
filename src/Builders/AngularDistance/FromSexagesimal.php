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

    protected Rotation $direction;

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
    }

    /**
     * Calc sexagesimal degrees.
     */
    protected function calcDegrees(): void 
    {
        $degrees = 
            ModularRelativeNumber::createFromExtremes(
                $this->degrees->value
                     ->plus($this->degrees_input)
                     ->mul($this->direction_input->value),
                AngularDistance::MIN,
                AngularDistance::MAX
            )->value;
        $this->degrees = new Degrees(
            $degrees->abs()->value
        );
        $this->direction = 
            $degrees->isPositive() ?
            Rotation::COUNTER_CLOCKWISE :
            Rotation::CLOCKWISE;
    }

    /**
     * Calc sexagesimal minutes.
     */
    protected function calcMinutes(): void 
    {
        $this->degrees = new Degrees(
            $this->minutes_input
                 ->plus($this->minutes->value)
                 ->div(Minutes::MAX)
                 ->floor()
        );
        $this->minutes = new Minutes(
            $this->minutes_input
                 ->sub($this->degrees->value->mul(Minutes::MAX))
                 ->plus($this->minutes->value)
        );
    }

    /**
     * Calc sexagesimal seconds.
     */
    protected function calcSeconds(): void 
    {
        $this->minutes = new Minutes(
            $this->seconds_input->div(Seconds::MAX)->floor()
        );
        $this->seconds = new Seconds(
            $this->seconds_input->sub($this->minutes->value->mul(Seconds::MAX))
        );
    }

    /**
     * Calc the `Angle`'s direction.
     */
    protected function calcSign(): void 
    {
        if ($this->isNullAngle())
            $this->direction = Rotation::COUNTER_CLOCKWISE;
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
        $this->calcFromLessToMostSignificantValue();
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