<?php
namespace MarcoConsiglio\Goniometry\Builders\AngularDistance;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\Angle\FromSexagesimal as AngleFromSexagesimal;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use Override;

class FromSexagesimal extends AngleFromSexagesimal
{
    /**
     * @return array{SexagesimalDegrees,SexadecimalAngularDistance,null}
     */
    #[Override]
    public function fetchData(): array
    {
        $angle = Angle::createFromValues(
            $this->degrees->value(),
            $this->minutes->value(),
            $this->seconds->value(),
            $this->direction
        );
        $sexadecimal = new SexadecimalAngularDistance($angle->toSexadecimalDegrees()->value);
        $builder = new FromSexadecimal($sexadecimal);
        return $builder->fetchData();
    }
}