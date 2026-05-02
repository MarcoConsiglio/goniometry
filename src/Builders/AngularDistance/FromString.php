<?php
namespace MarcoConsiglio\Goniometry\Builders\AngularDistance;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\Angle\FromString as AngleFromString;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use Override;

class FromString extends AngleFromString
{
    /**
     * @return array{SexagesimalDegrees,SexadecimalAngularDistance,null}
     */
    #[Override]
    public function fetchData(): array
    {
        [$sexagesimal] = parent::fetchData();
        $angle = Angle::createFromString($sexagesimal);
        $sexadecimal = new SexadecimalAngularDistance($angle->toSexadecimalDegrees()->value);
        return new FromSexadecimal($sexadecimal)->fetchData();
    }
}