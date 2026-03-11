<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use RoundingMode;

/**
 * Represents a sum builder.
 */
abstract class SumBuilder extends AngleBuilder
{
    /**
     * The first addend.
     *
     * @var Angle
     */
    protected Angle $alfa;

    /**
     * The second addend.
     *
     * @var Angle
     */
    protected Angle $beta;

    /**
     * The operation direction.
     */
    protected Direction $operation;

    /**
     * The decimal sum of the two angles.
     * 
     * @deprecated
     */
    protected float $decimal_sum = 0.0;

    /**
     * The reminder used in calculations.
     */
    protected Number $reminder;

    /**
     * The precision of the decimal value used
     * int the sum calculation.
     * 
     * @deprecated BCMath provides arbitrary precision.
     */
    protected int $decimal_precision = 0;

    /**
     * Construct the SumBuilder with two angles.
     *
     * @param Angle $alfa
     * @param Angle $beta
     */
    public function __construct(Angle $alfa, Angle $beta)
    {
        $this->alfa = $alfa;
        $this->beta = $beta;
        $this->reminder = new Number(0);
    }

    /**
     * It checks that both angle operands are positive full angles.
     *
     * @return boolean
     */  
    protected function bothAnglesAreFullPositiveAngles(): bool
    {
        return 
            $this->isFullAngle($this->alfa, Direction::COUNTER_CLOCKWISE) && 
            $this->isFullAngle($this->beta, Direction::COUNTER_CLOCKWISE);
    }

    /**
     * It checks that both angle operands are negative full angles.
     *
     * @return boolean
     */  
    protected function bothAnglesAreFullNegativeAngles(): bool
    {
        return 
            $this->isFullAngle($this->alfa, Direction::CLOCKWISE) && 
            $this->isFullAngle($this->beta, Direction::CLOCKWISE);
    }

    /**
     * It checks that both angle operands are null angles.
     *
     * @return boolean
     */
    protected function bothAnglesAreNullAngles(): bool
    {
        return $this->isNullAngle($this->alfa) && $this->isNullAngle($this->beta);
    }


    /**
     * It checks that an $angle is a full angle.
     *
     * @param Angle $angle
     * @param Direction $sign The expected sign of the angle being checked.
     * @return boolean
     */
    protected function isFullAngle(Angle $angle, Direction $sign): bool
    {
        $sign = $sign >= 0 ? Direction::COUNTER_CLOCKWISE : Direction::CLOCKWISE;
        return $angle->direction == $sign && $angle->isEqual(Degrees::MAX) ;
    }

    /**
     * It checks that an $angle is a null angle.
     *
     * @param Angle $angle
     * @return boolean
     */
    protected function isNullAngle(Angle $angle): bool
    {
        return $angle->isEqual(0);
    }
}