<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Comparisons\Comparison as GeneralComparison;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy\Types\AngleType;

/**
 * A comparison of angles within an acceptable error.
 * 
 * @internal
 */
abstract class Comparison extends GeneralComparison
{
    /**
     * The left operand of the comparison.
     */
    protected Angle $alfa;

    /**
     * The right operand of the comparison.
     */    
    protected Angle $beta;

    /**
     * The acceptable error within which comparison is successful.
     */
    protected Angle $delta;

    /**
     * Construct the `Comparison` between the two angles `$alfa` and `$beta`.
     * 
     * @param Angle $alfa The left operand of the comparison.
     * @param Angle $beta The right operand of the comparison.
     * @param Angle $delta The acceptable error within which comparison is successful.
     */
    public function __construct(
        Angle $alfa,
        Angle $beta,
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
    protected function getBetaType(): AngleType
    {
        return new AngleType($this->beta, $this->delta);
    }
}