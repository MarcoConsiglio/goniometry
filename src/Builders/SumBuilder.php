<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use RoundingMode;

/**
 * Represents a sum builder.
 */
abstract class SumBuilder extends AngleBuilder
{
    /**
     * The decimal sum of the two `Angle`s.
     */
    protected SexadecimalDegrees $decimal_sum;

    /**
     * The reminder used in calculations.
     */
    protected Number $reminder;

    /**
     * Construct the SumBuilder with two `Angle`s.
     */
    public function __construct(protected Angle $alfa, protected Angle $beta)
    {
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
        return $angle->direction == $sign && $angle->isEqualTo(Degrees::MAX) ;
    }

    /**
     * It checks that an $angle is a null angle.
     *
     * @param Angle $angle
     * @return boolean
     */
    protected function isNullAngle(Angle $angle): bool
    {
        return $angle->isEqualTo(0);
    }
}