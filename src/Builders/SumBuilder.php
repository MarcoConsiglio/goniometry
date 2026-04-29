<?php
namespace MarcoConsiglio\Goniometry\Builders;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;

/**
 * An `Angle` sum builder.
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