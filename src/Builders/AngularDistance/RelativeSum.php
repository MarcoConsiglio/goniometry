<?php
namespace MarcoConsiglio\Goniometry\Builders\AngularDistance;

use MarcoConsiglio\Goniometry\Builders\Angle\RelativeSum as AngleRelativeSum;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;

/**
 * Sum two `Angle` resulting in a relative sum.
 * 
 * @internal
 */
class RelativeSum extends AngleRelativeSum
{
    /**
     * Sum the two addend.
     */
    #[\Override]
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
    #[\Override]
    public function fetchData(): array
    {
        $this->calcSum();
        return new FromSexadecimal($this->decimal_sum)->fetchData();
    }
}