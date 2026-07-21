<?php
namespace MarcoConsiglio\Goniometry\Builders\AngularDistance;

use MarcoConsiglio\Goniometry\RadianAngularDistance;
use MarcoConsiglio\Goniometry\Builders\Builder;
use MarcoConsiglio\Goniometry\SexadecimalAngularDistance;
use Override;

/**
 *  Build an `AngularDistance` starting from a radian value.
 * 
 * @internal
 */
class FromRadian extends FromSexadecimal
{
    /**
     * The input radian value.
     */
    protected RadianAngularDistance $radian;

    /**
     * Constructs `FromRadian` `AngleBuilder` with a `$radian` value.
     */
    public function __construct(float|RadianAngularDistance $radian)
    {
        $this->radian = 
            $radian instanceof RadianAngularDistance ?
            $radian : new RadianAngularDistance($radian);
        $this->decimal = new SexadecimalAngularDistance($this->radian->value->toDegrees());
    }

    /**
     * Fetches the data to build an `AngularDistance`.
     *
     * @return array{SexagesimalDegrees,SexadecimalAngularDistance,RadianAngularDistance}
     */    
    #[Override]
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