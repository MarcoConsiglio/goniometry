<?php
namespace MarcoConsiglio\Goniometry\Builders\AngularDistance;

use MarcoConsiglio\Goniometry\AngularDistanceRadian;
use MarcoConsiglio\Goniometry\Builders\Angle\AngleBuilder;
use Override;

/**
 *  Builds an `AngularDistance` starting from a radian value.
 */
class FromRadian extends AngleBuilder
{
    /**
     * The input radian value.
     */
    protected AngularDistanceRadian $radian;

    /**
     * Constructs `FromRadian` `AngleBuilder` with a `$radian` value.
     */
    public function __construct(float|AngularDistanceRadian $radian)
    {
        $this->radian = 
            $radian instanceof AngularDistanceRadian ?
            $radian : new AngularDistanceRadian($radian);
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
     * Checks for overflow above/below +/-360°.
     * 
     * @codeCoverageIgnore
     */
    protected function checkOverflow(): void {/* No need check overflow. */}

    /**
     * Fetches the data to build an `AngularDistance`.
     *
     * @return array{SexagesimalDegrees,SexadecimalAngularDistance,AngularDistanceRadian}
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