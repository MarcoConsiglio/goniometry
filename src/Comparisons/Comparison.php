<?php
namespace MarcoConsiglio\Goniometry\Comparisons;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Types\AngleType;
use MarcoConsiglio\Goniometry\Comparisons\Types\ComparisonType;
use MarcoConsiglio\Goniometry\Comparisons\Types\FloatType;
use MarcoConsiglio\Goniometry\Comparisons\Types\InputType;
use MarcoConsiglio\Goniometry\Comparisons\Types\IntType;
use MarcoConsiglio\Goniometry\Comparisons\Types\StringType;

abstract class Comparison
{
    /**
     * The left operand of the comparison.
     */
    protected Angle $alfa;

    /**
     * The right operand of the comparison.
     */
    protected string|int|float|Angle $beta;

    /**
     * The strategy used to compare two angles.
     */
    protected Strategy $comparison_strategy;

    /**
     * The precision used when comparing an Angle against a float type 
     * variable.
     */
    protected int $float_precision = PHP_FLOAT_DIG;

    /**
     * Construct the Comparison with the two angles $alfa and $beta.
     */
    public function __construct(Angle $alfa, string|int|float|Angle $beta)
    {
        $this->alfa = $alfa;
        $this->beta = $beta;
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
        if (is_string($this->beta)) new StringType($this->beta);
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
    abstract public function compare(): bool;
}