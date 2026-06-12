<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Fuzzy\Types\AngularDistanceType;
use MarcoConsiglio\Goniometry\Comparisons\Comparison as GeneralComparison;
use MarcoConsiglio\Goniometry\Comparisons\InputType;
use Override;

abstract class Comparison extends GeneralComparison
{
    protected Angle $delta;

    public function __construct(
        AngularDistance $alfa, 
        AngularDistance $beta,
        Angle $delta
    ) {
        $this->delta = $delta->absolute();
        parent::__construct($alfa, $beta);
    }

    #[Override]
    protected function getBetaType(): AngularDistanceType
    {
        return new AngularDistanceType($this->beta);
    }
}