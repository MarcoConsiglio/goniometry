<?php
namespace MarcoConsiglio\Goniometry\Comparisons;

use Error;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\FloatType as AngleAndFloatType;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\AngleType;
use MarcoConsiglio\Goniometry\Comparisons\InputType;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\IntType as AngleAndIntType;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\StringType as AngleAndStringType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\AngularDistanceType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\FloatType as AngularDistanceAndFloatType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\IntType as AngularDistanceAndIntType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\StringType as AngularDistanceAndStringType;
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
     * 
     * @throws Error if there are no comparison strategies available for the type of `$alfa`.
     */
    protected function getBetaType(): InputType
    {
        if ($this->alfa instanceof Angle) {
            if ($this->beta instanceof Angle) return new AngleType($this->beta);
            if (is_string($this->beta)) return new AngleAndStringType($this->beta);
            if (is_int($this->beta)) return new AngleAndIntType($this->beta);
            return new AngleAndFloatType($this->beta, $this->precision);
        }
        if ($this->alfa instanceof AngularDistance) {
            if ($this->beta instanceof AngularDistance) return new AngularDistanceType($this->beta);
            if (is_string($this->beta)) return new AngularDistanceAndStringType($this->beta);
            if (is_int($this->beta)) return new AngularDistanceAndIntType($this->beta);
            return new AngularDistanceAndFloatType($this->beta);
        }
        $unknown_class = get_class($this->alfa);
        throw new Error("There are no comparison strategies available for class {$unknown_class}.");
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