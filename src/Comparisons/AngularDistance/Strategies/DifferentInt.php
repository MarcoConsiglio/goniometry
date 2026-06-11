<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\DifferentInt as AngleDifferentInt;
use MarcoConsiglio\Goniometry\Comparisons\AngularDistance\ComparisonStrategy;
use Override;

class DifferentInt extends AngleDifferentInt
{
    public function __construct(AngularDistance $alfa, protected int $beta)
    {
        parent::__construct($alfa, $beta);
    }

    #[Override]
    public function compare(): bool
    {
        return ! new EqualInt($this->alfa, $this->beta)->compare();
    }
}