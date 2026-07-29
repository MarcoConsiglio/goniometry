<?php
namespace MarcoConsiglio\Goniometry\Builders\AngularDistance;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexagesimal as AngleFromSexagesimal;
use MarcoConsiglio\Goniometry\Builders\Traits\CalcOrderForSexagesimals;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use Override;

/**
 *  Build an `AngularDistance` starting from sexagesimal values.
 * 
 * @internal
 */
class FromSexagesimal extends AngleFromSexagesimal
{
    use CalcOrderForSexagesimals;

    protected Number $degrees_input;

    protected Number $minutes_input;

    protected Number $seconds_input;

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
        $this->degrees_input =
            $this->minutes_input->sub($this->minutes->value)
            ->div(Minutes::MAX)->plus($this->degrees_input)
            ->mod(AngularDistance::MAX);
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
            $this->direction = Rotation::COUNTER_CLOCKWISE;
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
     * @return array{SexagesimalDegrees,SexadecimalAngularDistance,null}
     */
    public function fetchData(): array
    {
        $sexadecimal = new SexadecimalAngularDistance(
            $this->degrees_input->plus(
                $this->minutes_input->div(Minutes::MAX)
            )->plus(
                $this->seconds_input->div(Minutes::MAX * Seconds::MAX)
            )->mul($this->direction_input->value)
        );
        $angular_distance = AngularDistance::createFromDecimal($sexadecimal);
        return [
            $angular_distance->toSexagesimalDegrees(),
            $angular_distance->toSexadecimalDegrees(),
            null  // Radian
        ];
    }
}