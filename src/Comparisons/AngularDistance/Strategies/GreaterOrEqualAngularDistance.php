<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualAngle;
use Override;

class GreaterOrEqualAngularDistance extends GreaterOrEqualAngle
{
    public function __construct(AngularDistance $alfa, AngularDistance $beta)
    {
        parent::__construct($alfa, $beta);
    }

    #[Override]
    public function compare(): bool
    {
        return
            new EqualAngularDistance($this->alfa, $this->beta)->compare() ||
            new GreaterAngularDistance($this->alfa, $this->beta)->compare();
    }
}