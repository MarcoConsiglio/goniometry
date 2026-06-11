<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualAngle;
use Override;

class LesserOrEqualAngularDistance extends LesserOrEqualAngle
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
            new LesserAngularDistance($this->alfa, $this->beta)->compare();
    }
}