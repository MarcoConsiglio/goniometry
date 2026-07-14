<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularMeasure;
use MarcoConsiglio\Goniometry\Comparisons\Comparison as GeneralComparison;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy\Types\AngleType;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;

/**
 * A comparison of angles within an acceptable error.
 * 
 * @internal
 */
abstract class Comparison extends GeneralComparison
{
    /**
     * The acceptable error within which comparison is successful.
     */
    protected Angle $delta;

    /**
     * Construct the `Comparison` between the two angles `$alfa` and `$beta`.
     * 
     * @param AngularMeasure $alfa The left operand of the comparison.
     * @param AngularMeasure $beta The right operand of the comparison.
     * @param Angle $delta The acceptable error within which comparison is successful.
     */
    public function __construct(
        AngularMeasure $alfa,
        AngularMeasure $beta,
        Angle $delta
    ) {
        $this->alfa = $alfa->absolute();
        $this->beta = $beta->absolute();
        $this->delta = $delta->absolute();
        $this->setComparisonStrategy();
    }

    /**
     * Return an `InputType` object that represent the type
     * of the right operand of the fuzzy comparison.
     */
    #[\Override]
    protected function getBetaType(): AngleType
    {
        return new AngleType($this->beta);
    }
}