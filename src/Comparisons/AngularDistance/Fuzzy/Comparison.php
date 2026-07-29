<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy\Types\AngularDistanceType;
use MarcoConsiglio\Goniometry\Comparisons\Comparison as GeneralComparison;

/**
 * A comparison of angular distances within an acceptable error.
 * 
 * @internal
 */
abstract class Comparison extends GeneralComparison
{
    /**
     * Construct the `Comparison` between the two angular distances `$alfa` and `$beta`.
     * 
     * @param AngularDistance $alfa The left operand of the comparison.
     * @param AngularDistance $beta The right operand of the comparison.
     * @param Angle $delta The acceptable error within which comparison is successful.
     */
    public function __construct(
        protected AngularDistance $alfa, 
        protected AngularDistance $beta,
        protected Angle $delta
    ) {
        $this->delta = $delta->absolute();
        $this->setComparisonStrategy();
    }

    /**
     * Return an `InputType` object that represent the type
     * of the right operand of the fuzzy comparison.
     */
    protected function getBetaType(): AngularDistanceType
    {
        return new AngularDistanceType($this->beta, $this->delta);
    }
}