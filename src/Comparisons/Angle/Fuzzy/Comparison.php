<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Angle\Fuzzy;

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
    protected AngleInterface $delta;

    /**
     * Construct the `Comparison` between the two angles `$alfa` and `$beta`.
     * 
     * @param AngleInterface $alfa The left operand of the comparison.
     * @param AngleInterface $beta The right operand of the comparison.
     * @param AngleInterface $delta The acceptable error within which comparison is successful.
     */
    public function __construct(
        AngleInterface $alfa,
        AngleInterface $beta,
        AngleInterface $delta
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