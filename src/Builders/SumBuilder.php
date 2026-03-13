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
     * Construct the SumBuilder with two `Angle`s.
     */
    public function __construct(protected Angle $alfa, protected Angle $beta) {}
}