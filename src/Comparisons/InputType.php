<?php
namespace MarcoConsiglio\Goniometry\Comparisons;

use Error;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Comparisons\Comparison;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

/**
 * The beta angle `InputType` in a comparison between alfa and beta angles.
 * 
 * @internal
 */
abstract class InputType
{
    /**
     * @throws Error for `$comparison` with no strategy.
     * @return Strategy This is not true, it always throws `Error`. The return 
     * type serves only to keep the static type checker happy.
     */
    protected function throwError(Comparison $comparison): Strategy
    {
        $unknown_class = get_class($comparison);
        throw new Error("There's no strategy for {$unknown_class} comparison.");
    }
}