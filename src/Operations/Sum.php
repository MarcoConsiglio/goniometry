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
     * Constructs the Sum.
     *
     * @param SumBuilder
     * @return void
     */
    public function __construct(SumBuilder $builder)
    {
        parent::__construct($builder);
    }
}