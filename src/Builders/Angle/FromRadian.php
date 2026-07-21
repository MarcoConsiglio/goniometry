<?php
namespace MarcoConsiglio\Goniometry\Builders\Angle;

use MarcoConsiglio\Goniometry\Builders\Builder;
use MarcoConsiglio\Goniometry\RadianAngle;
use MarcoConsiglio\Goniometry\SexadecimalAngle;

/**
 *  Build an `Angle` starting from a radian value.
 * 
 * @internal
 */
class FromRadian extends FromSexadecimal
{
    /**
     * The radian value used to build an `Angle`.
     */
    protected RadianAngle $radian;

    /**
     * Constructs `FromRadian` `AngleBuilder` with a `$radian` value.
     */
    public function __construct(float|RadianAngle $radian)
    {
        $this->radian = 
            $radian instanceof RadianAngle ?
            $radian : new RadianAngle($radian);
        $this->decimal = new SexadecimalAngle($this->radian->value->toDegrees());
    }

    /**
     * Fetches the data to build an `Angle`.
     *
     * @return array{SexagesimalDegrees,SexadecimalDegrees,RadianAngle}
     */
    public function fetchData(): array
    {
        [$sexagesimal, $sexadecimal] = parent::fetchData();
        return [
            $sexagesimal,
            $sexadecimal,
            $this->radian
        ];
    }
}