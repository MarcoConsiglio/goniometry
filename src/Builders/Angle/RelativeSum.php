<?php
namespace MarcoConsiglio\Goniometry\Builders\Angle;

use MarcoConsiglio\Goniometry\SexadecimalAngle;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;

/**
 * Sum two `Angle`s resulting in a relative sum.
 * 
 * @internal
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
        $this->decimal_sum = new SexadecimalAngle(
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
        $builder = new FromSexadecimal($this->decimal_sum);
        return $builder->fetchData();
    }
}