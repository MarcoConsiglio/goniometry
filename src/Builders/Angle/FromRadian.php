<?php
namespace MarcoConsiglio\Goniometry\Builders\Angle;

use MarcoConsiglio\Goniometry\Radian;
/**
 *  Builds an `Angle` starting from a radian value.
 */
class FromRadian extends AngleBuilder
{
    /**
     * The radian value used to build an `Angle`.
     */
    protected Radian $radian;

    /**
     * Constructs an `AngleBuilder` with a radian value.
     */
    public function __construct(float|Radian $radian)
    {
        if ($radian instanceof Radian)
            $this->radian = $radian;
        else
            $this->radian = new Radian($radian);

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
     * Fetches the data to build an `Angle`.
     *
     * @return array{SexagesimalDegrees,SexadecimalDegrees,Radian}
     */
    public function fetchData(): array
    {
        [
            $sexagesimal,
            $sexadecimal,
        ] = new FromSexadecimal(
            $this->radian->value->toDegrees()->toFloat()
        )->fetchData();
        return [
            $sexagesimal,
            $sexadecimal,
            $this->radian
        ];
    }
}