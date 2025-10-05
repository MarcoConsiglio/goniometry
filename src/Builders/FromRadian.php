<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Exceptions\AngleOverflowException;

/**
 *  Builds an angle starting from a radian value.
 */
class FromRadian extends AngleBuilder
{
    /**
     * The radian value used to build an Angle.
     *
     * @var float
     */
    protected float $radian;

    /**
     * Constructs an AngleBuilder with a decimal value.
     *
     * @param float $radian
     */
    public function __construct(float $radian)
    {
        $this->radian = $radian;
        $this->checkOverflow($radian);
    }

    /**
     * Calcs degrees.
     *
     * @return void
     * @codeCoverageIgnore
     */
    public function calcDegrees()
    {
        
    }

    /**
     * Calcs minutes.
     *
     * @return void
     * @codeCoverageIgnore
     */
    public function calcMinutes()
    {
        
    }

    /**
     * Calcs seconds.
     *
     * @return void
     * @codeCoverageIgnore
     */
    public function calcSeconds()
    {
        
    }

    /**
     * Calcs sign.
     *
     * @return void
     * @codeCoverageIgnore
     */
    public function calcSign()
    {
        
    }

    /**
     * Checks for overflow above/below +/-360°.
     *
     * @param mixed $data
     * @return void
     */
    public function checkOverflow()
    {
        $this->validate($this->radian);
    }

    /**
     * Tells if the radian is more than 2 * PI.
     *
     * @param float $data
     * @return void
     */
    protected function validate(float $data)
    {
        if (abs($data) > Angle::MAX_RADIAN) {
            throw new AngleOverflowException("The angle can't be greater than 360°.");
        }
    }

    /**
     * Fetches the data to build an Angle.
     *
     * @return array
     */
    public function fetchData(): array
    {
        return (new FromDecimal(rad2deg($this->radian)))->fetchData();
    }
}