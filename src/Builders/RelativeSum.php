<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;

/**
 * Sum two `Angle`s resulting in a relative sum.
 */
class RelativeSum extends SumBuilder
{
    /**
     * Sum the two addend.
     */
    protected function calcSum(): void
    {
        $alfa = $this->alfa->toSexadecimalDegrees()->value;
        $beta = $this->beta->toSexadecimalDegrees()->value;
        $this->decimal_sum = new SexadecimalDegrees(
            $alfa->plus($beta)
        );       
    }

    /**
     * Fetch data to build an `Angle` which is the sum
     * between two `Angle`s.
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
     * It calcs the result sign.
     * 
     * @codeCoverageIgnore
     */
    protected function calcSign(): void {/* No need to calc sign as it is done in fetchData() */}

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

    /**
     * Check for overflow above/below ±360°.
     * 
     * @codeCoverageIgnore
     */
    protected function checkOverflow(): void{/* No need to check overflow */}
}