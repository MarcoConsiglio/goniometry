<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies\Fuzzy;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\Fuzzy\EqualAngle;

class EqualAngularDistance extends EqualAngle
{
    public function __construct(AngularDistance $alfa, AngularDistance $beta, Angle $delta)
    {
        $this->alfa = $alfa;
        $this->beta = $beta;
        $this->delta = $delta;
        $this->calcEpsilon();
        $this->calcLowExtreme();
        $this->calcHighExtreme();
    }
}