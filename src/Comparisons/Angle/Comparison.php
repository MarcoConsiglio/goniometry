<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\FloatType;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\AngleType;
use MarcoConsiglio\Goniometry\Comparisons\InputType;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\IntType;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\StringType;
use MarcoConsiglio\Goniometry\Interfaces\Comparison\Strategy;
use MarcoConsiglio\Goniometry\Comparisons\Comparison as GeneralComparison;

/**
 * A comparison between angles.
 * 
 * @internal
 */
abstract class Comparison extends GeneralComparison
{
    /**
     * The strategy used to compare two angles.
     */
    protected Strategy $comparison_strategy;

    /**
     * Construct the `Comparison` with the two angles `$alfa` and `$beta`.
     * 
     * @param AngularMeasure $alfa The left operand of the comparison.
     * @param string|int|float|AngularMeasure $beta The right operand of the comparison.
     */
    public function __construct(
        protected AngularMeasure $alfa,
        protected string|int|float|AngularMeasure $beta
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