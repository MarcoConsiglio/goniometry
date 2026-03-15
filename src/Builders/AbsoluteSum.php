<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;

/**
 * Sum two `Angle`s resulting in an absolute sum.
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
        $builder = new FromDecimal($this->decimal_sum);
        return $builder->fetchData();
    }

    /**
     * Sum the two addend.
     */
    protected function calcSum()
    {
        $this->calcSign();
        $alfa = $this->alfa->toDecimal()->value;
        $beta = $this->beta->toDecimal()->value;
        $this->decimal_sum = new SexadecimalDegrees(
            $alfa->plus($beta)->plus(Degrees::MAX)
        );
    }

    /**
     * It calcs the result sign.
     * 
     * The sign/direction will be always positive/counterclockwise.
     */
    protected function calcSign(): void
    {
        $this->direction = Direction::COUNTER_CLOCKWISE;
    }

    /**
     * Check for overflow above/below ±360°.
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