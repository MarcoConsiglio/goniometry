<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Radian;
use MarcoConsiglio\Goniometry\Seconds;
use RoundingMode;

/**
 *  Builds an angle starting from a radian value.
 */
class FromRadian extends AngleBuilder
{
    /**
     * The radian value used to build an `Angle`.
     */
    protected Radian $radian;

    /**
     * Constructs an AngleBuilder with a decimal value.
     */
    public function __construct(float $radian)
    {
        $this->radian = new Radian($radian);
    }

    /**
     * Calc degrees.
     * 
     * @codeCoverageIgnore
     */
    protected function calcDegrees() {}


    /**
     * Calcs minutes.
     * 
     * @codeCoverageIgnore
     */
    protected function calcMinutes() {}

    /**
     * Calcs seconds.
     * 
     * @codeCoverageIgnore
     */
    protected function calcSeconds() {}

    /**
     * Calcs sign.
     * 
     * @codeCoverageIgnore
     */
    protected function calcSign() {}

    /**
     * Checks for overflow above/below +/-360°.
     * 
     * @codeCoverageIgnore
     */
    protected function checkOverflow() {/* No need check overflow. */}

    /**
     * Fetches the data to build an Angle.
     *
     * @return array{Degrees,Minutes,Seconds,Direction,float,float}
     */
    public function fetchData(): array
    {
        $result = new FromDecimal(
            $this->radian->value->toDegrees()->toFloat()
        )->fetchData();
        return [
            $result[0],     // Degrees
            $result[1],     // Minutes
            $result[2],     // Seconds
            $result[3],     // Direction
            $result[4],     // Original decimal value
            $this->radian,  // Original radian value
        ];
    }
}