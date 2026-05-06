<?php
namespace MarcoConsiglio\Goniometry\Builders\AngularDistance;

use MarcoConsiglio\Goniometry\Builders\Angle\RelativeSum as AngleRelativeSum;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;

class RelativeSum extends AngleRelativeSum
{
    /**
     * Sum the two addend.
     */
    protected function calcSum(): void
    {
        $alfa = $this->alfa->toSexadecimalDegrees()->value;
        $beta = $this->beta->toSexadecimalDegrees()->value;
        $this->decimal_sum = new SexadecimalAngularDistance(
            $alfa->plus($beta)
        );       
    }

    /**
     * Fetch data to build an `AngularDistance` which is the sum
     * between two `AngularDistance`s.
     *
     * @return array{SexagesimalDegrees,SexadecimalAngularDistance,null}
     */
    public function fetchData(): array
    {
        $this->calcSum();
        return new FromSexadecimal($this->decimal_sum)->fetchData();
    }
}