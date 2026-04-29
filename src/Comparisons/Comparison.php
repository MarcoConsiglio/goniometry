<?php
namespace MarcoConsiglio\Goniometry\Comparisons;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Types\AngleType;
use MarcoConsiglio\Goniometry\Comparisons\Types\FloatType;
use MarcoConsiglio\Goniometry\Comparisons\Types\InputType;
use MarcoConsiglio\Goniometry\Comparisons\Types\IntType;
use MarcoConsiglio\Goniometry\Comparisons\Types\StringType;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;

/**
 * A comparison between angles.
 */
abstract class Comparison
{
    /**
     * The strategy used to compare two angles.
     */
    protected Strategy $comparison_strategy;

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
     * Construct the `Comparison` with the two angles `$alfa` and `$beta`.
     * 
     * @param Angle $alfa The left operand of the comparison.
     * @param string|int|float|Angle $beta The right operand of the comparison.
     */
    public function __construct(
        protected Angle $alfa,
        protected string|int|float|Angle $beta
    ) {
        $this->setComparisonStrategy();
    }

    /**
     * Return an `InputType` object that represent the type
     * of the right operand of the `Comparison`.
     */
    protected function getBetaType(): InputType
    {
        if ($this->beta instanceof Angle) {
            return new AngleType($this->beta);
        }
        if (is_string($this->beta)) return new StringType($this->beta);
        if (is_int($this->beta)) return new IntType($this->beta);
        return new FloatType($this->beta, $this->precision);
    }

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
        $this->normalizePrecision();
    }

    /**
     * Normalize precision within the range 0 to `self::MAX_PRECISION`.
     */
    protected function normalizePrecision(): void
    {
        $this->precision = abs($this->precision);
        if ($this->precision > self::MAX_PRECISION) 
            $this->precision = self::MAX_PRECISION;
    }
}