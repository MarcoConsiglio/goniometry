<?php
namespace MarcoConsiglio\Goniometry\Comparisons;

use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

/**
 * A comparison between angles.
 * 
 * @internal
 */
abstract class Comparison
{
    /**
     * The precision used when comparing an `Angle` against a `float` type 
     * variable.
     */
    protected int $precision = self::MAX_PRECISION;

    /**
     * The maximum allowed precision in every comparison.
     */
    public const int MAX_PRECISION = 54;   
    
    /**
     * The strategy used to compare two angles.
     */
    protected Strategy $comparison_strategy;

    /**
     * Set the comparison strategy based on the comparison type and
     * the type of the right operand of a `Comparison`.
     */
    abstract protected function setComparisonStrategy(): void;

    /**
     * Perform the comparison.
     */
    public function compare(): bool
    {
        return $this->comparison_strategy->compare();
    }

    /**
     * Set the precision to use when comparing.
     */
    public function setPrecision(int $precision): void
    {
        $this->precision = $precision;
    }
}