<?php
namespace MarcoConsiglio\Goniometry\Operations;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\SumBuilder;

/**
 * Sums two angles.
 */
class Sum extends Angle
{

    /**
     * Decimal sum of the two addend.
     *
     * @var float
     */
    private float $decimal_sum;

    /**
     * Constructs the Sum.
     *
     * @param \MarcoConsiglio\Goniometry\Builders\SumBuilder
     * @return void
     */
    public function __construct(SumBuilder $builder)
    {
        [$this->degrees, $this->minutes, $this->seconds, $this->direction] = $builder->fetchData();
    }
}