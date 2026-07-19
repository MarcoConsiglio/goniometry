<?php
namespace MarcoConsiglio\Goniometry\Builders\Angle;

use BcMath\Number;
use MarcoConsiglio\Goniometry\Enums\Rotation;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\SexadecimalAngle;

/**
 * Sum two `Angle`s resulting in an absolute sum.
 * 
 * @internal
 */
class AbsoluteSum extends SumBuilder
{
    /**
     * Fetch data to build an `Angle` which is the absolute sum between two 
     * `Angle`s.
     *
     * @return array{SexagesimalDegrees,SexadecimalDegrees,null}
     */
    public function fetchData(): array
    {
        $this->calcSum();
        $builder = new FromSexadecimal($this->decimal_sum);
        return $builder->fetchData();
    }

    /**
     * Sum the two addend.
     */
    protected function calcSum()
    {
        $this->calcSign();
        $alfa = $this->alfa->toSexadecimalDegrees()->value;
        $beta = $this->beta->toSexadecimalDegrees()->value;
        $this->decimal_sum = new SexadecimalAngle(
            $alfa->plus($beta)
        );
        if ($this->decimal_sum->value->isNegative()) {
            $this->decimal_sum = new SexadecimalAngle(
                new Number(Degrees::MAX)->add($this->decimal_sum->value)
            );
        }
    }

    /**
     * It calcs the result sign.
     * 
     * The sign/direction will be always positive/counterclockwise.
     */
    protected function calcSign(): void
    {
        $this->direction = Rotation::COUNTER_CLOCKWISE;
    }

    /**
     * Not implemented as this is already done in `calcSum()` method.
     * 
     * @codeCoverageIgnore
     */
    protected function checkOverflow(): void {/* This is already done in calcSum() */}

    /**
     * Calc seconds.
     * 
     * @codeCoverageIgnore
     */
    protected function calcSeconds(): void {/* No need to calc seconds as it is done in fetchData() */}

    /**
     * Calc minutes.
     * 
     * @codeCoverageIgnore
     */
    protected function calcMinutes(): void {/* No need to calc minutes as it is done in fetchData() */}

    /**
     * Calc degrees.
     * 
     * @codeCoverageIgnore
     */
    protected function calcDegrees(): void {/* No need to calc degrees as it is done in fetchData() */}
}