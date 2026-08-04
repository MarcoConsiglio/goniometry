<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\AngularDistanceType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\FloatType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\IntType;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\StringType;
use MarcoConsiglio\Goniometry\Comparisons\Comparison as BaseComparison;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Types\InputType;

abstract class Comparison extends BaseComparison
{
    /**
     * Construct the `Comparison` with the two `Angle`s `$alfa` and `$beta`.
     * 
     * @param AngularDistance $alfa The left operand of the comparison.
     * @param string|int|float|AngularDistance $beta The right operand of the comparison.
     */
    public function __construct(
        protected AngularDistance $alfa,
        protected string|int|float|AngularDistance $beta
    ) {
        $this->setComparisonStrategy();
    }

    protected function getBetaType(): InputType
    {
        if ($this->beta instanceof AngularDistance) return new AngularDistanceType($this->beta);
        if (is_string($this->beta)) return new StringType($this->beta);
        if (is_int($this->beta)) return new IntType($this->beta);
        return new FloatType($this->beta);
    }
}