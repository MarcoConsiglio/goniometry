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
 * Represents a comparison between angles.
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
    protected int $float_precision = self::MAX_PRECISION;

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
     * Return an object that represent the type
     * of the right operand of the comparison.
     */
    protected function getBetaType(): InputType
    {
        if ($this->beta instanceof Angle) {
            return new AngleType($this->beta);
        }
        if (is_string($this->beta)) return new StringType($this->beta);
        if (is_int($this->beta)) return new IntType($this->beta);
        return new FloatType($this->beta, $this->float_precision);
    }

    /**
     * Set the comparison strategy based on the comparison type and
     * the type of the right operand of the comparison.
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
        $this->float_precision = $precision;
        $this->normalizePrecision();
    }

    /**
     * Normalizes precision within the range 0 to 54.
     */
    protected function normalizePrecision(): void
    {
        $this->float_precision = abs($this->float_precision);
        if ($this->float_precision > self::MAX_PRECISION) 
            $this->float_precision = self::MAX_PRECISION;
    }
}