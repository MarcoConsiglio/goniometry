<?php
namespace MarcoConsiglio\Goniometry\Builders\AngularDistance;

use MarcoConsiglio\Goniometry\RadianAngularDistance;
use MarcoConsiglio\Goniometry\Builders\Angle\AngleBuilder;
use Override;

/**
 *  Build an `AngularDistance` starting from a radian value.
 * 
 * @internal
 */
class FromRadian extends AngleBuilder
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
    }

    /**
     * Calc degrees.
     * 
     * @codeCoverageIgnore
     */
    protected function calcDegrees(): void {}


    /**
     * Calcs minutes.
     * 
     * @codeCoverageIgnore
     */
    protected function calcMinutes(): void {}

    /**
     * Calcs seconds.
     * 
     * @codeCoverageIgnore
     */
    protected function calcSeconds(): void {}

    /**
     * Calcs sign.
     * 
     * @codeCoverageIgnore
     */
    protected function calcSign(): void {}

    /**
     * Not implemented as there's no need to check for overflow above/below +/-360°.
     * 
     * @codeCoverageIgnore
     */
    protected function checkOverflow(): void {/* No need check overflow. */}

    /**
     * Fetches the data to build an `AngularDistance`.
     *
     * @return array{SexagesimalDegrees,SexadecimalAngularDistance,RadianAngularDistance}
     */    
    #[Override]
    public function fetchData(): array
    {
        [$sexagesimal, $sexadecimal] = new FromSexadecimal(
            $this->radian->value->toDegrees()->toFloat()
        )->fetchData();
        return [
            $sexagesimal,
            $sexadecimal,
            $this->radian
        ];
    }
}