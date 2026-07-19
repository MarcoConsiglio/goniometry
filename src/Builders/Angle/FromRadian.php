<?php
namespace MarcoConsiglio\Goniometry\Builders\Angle;

use MarcoConsiglio\Goniometry\RadianAngle;
/**
 *  Build an `Angle` starting from a radian value.
 * 
 * @internal
 */
class FromRadian extends AngleBuilder
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
     * Fetches the data to build an `Angle`.
     *
     * @return array{SexagesimalDegrees,SexadecimalDegrees,RadianAngle}
     */
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