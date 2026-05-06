<?php
namespace MarcoConsiglio\Goniometry\Builders\Angle;

use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;

/**
 * An `Angle` sum builder.
 * 
 * @internal
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
    public function __construct(protected AngleInterface $alfa, protected AngleInterface $beta) {}
}