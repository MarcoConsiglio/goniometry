<?php
namespace MarcoConsiglio\Goniometry\Builders\Angle;

use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Builders\Builder;
use MarcoConsiglio\Goniometry\Interfaces\SexadecimalValue;

/**
 * An `Angle` sum builder.
 * 
 * @internal
 */
abstract class SumBuilder extends Builder
{
    /**
     * The decimal sum of the two `Angle`s.
     */
    protected SexadecimalValue $decimal_sum;

    /**
     * Construct the SumBuilder with two `Angle`s.
     */
    public function __construct(protected AngularMeasure $alfa, protected AngularMeasure $beta) {}
}