<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\AngleType;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\FloatType;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\InputType;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\IntType;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Types\StringType;
use MarcoConsiglio\Goniometry\Comparisons\Comparison as BaseComparison;

abstract class Comparison extends BaseComparison
{
    /**
     * Construct the `Comparison` with the two `Angle`s `$alfa` and `$beta`.
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

    protected function getBetaType(): InputType
    {
        if ($this->beta instanceof Angle) return new AngleType($this->beta);
        if (is_string($this->beta)) return new StringType($this->beta);
        if (is_int($this->beta)) return new IntType($this->beta);
        return new FloatType($this->beta, $this->precision);
    }
}