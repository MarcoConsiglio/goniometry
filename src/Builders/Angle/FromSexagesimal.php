<?php
namespace MarcoConsiglio\Goniometry\Builders\Angle;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Builders\Builder;
use MarcoConsiglio\Goniometry\Builders\Traits\CalcOrderForSexagesimals;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;

/**
 *  Build an `Angle` starting from degrees, minutes, seconds and direction.
 * 
 * @internal
 */
class FromSexagesimal extends Builder
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
        $this->degrees = new Degrees($this->degrees_input);
    }

    /**
     * Calc sexagesimal minutes.
     */
    protected function calcMinutes(): void 
    {
        $this->minutes = new Minutes($this->minutes_input);
        $this->degrees_input = $this->degrees_input->plus(
            $this->minutes_input->divmod(Minutes::MAX)[0]
        );
        $this->minutes_input = $this->minutes_input->sub(
            $this->minutes_input->divmod(Minutes::MAX)[0]->mul(Minutes::MAX)
        );
    }

    /**
     * Calc sexagesimal seconds.
     */
    protected function calcSeconds(): void 
    {
        $this->seconds = new Seconds($this->seconds_input);
        $this->minutes_input = 
            $this->minutes_input->plus(
                $this->seconds_input->divmod(Seconds::MAX)[0]
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
     * @return array{SexagesimalDegrees,null,null}
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