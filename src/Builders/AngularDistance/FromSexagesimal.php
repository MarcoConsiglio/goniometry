<?php
namespace MarcoConsiglio\Goniometry\Builders\AngularDistance;

use MarcoConsiglio\Goniometry\Builders\Angle\FromSexagesimal as AngleFromSexagesimal;
use MarcoConsiglio\Goniometry\SexagesimalDegrees;
use Override;

/**
 *  Build an `AngularDistance` starting from sexagesimal values.
 * 
 * @internal
 */
class FromSexagesimal extends AngleFromSexagesimal
{
    /**
     * Fetches the data to build an `AngularDistance`.
     * 
     * @return array{SexagesimalDegrees,null,null}
     */
    #[Override]
    public function fetchData(): array
    {
        $this->calcFromLessToMostSignificantValue();
        return [
            new SexagesimalDegrees(
                $this->degrees,
                $this->minutes,
                $this->seconds,
                $this->direction
            ), null, null
        ];
    }
}