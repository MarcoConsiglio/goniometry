<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;

class EqualString extends ComparisonStrategy
{
    protected Angle $beta;

    public function __construct(Angle $alfa, string $beta)
    {
        parent::__construct($alfa);
        $this->beta = Angle::createFromString($beta);
    }

    public function compare(): bool
    {
        return new EqualAngle($this->alfa, $this->beta)->compare();
    }
}