<?php
namespace MarcoConsiglio\Goniometry\Comparisons\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;
use MarcoConsiglio\Goniometry\Minutes;
use MarcoConsiglio\Goniometry\Seconds;

class EqualInt extends ComparisonStrategy
{
    protected Angle $beta;

    public function __construct(Angle $alfa, int $beta)
    {
        parent::__construct($alfa);
        $direction = $beta >= 0 ? Direction::COUNTER_CLOCKWISE : Direction::CLOCKWISE;
        $this->beta = Angle::createFromValues(degrees: $beta, direction: $direction);
    }

    public function compare(): bool
    {
        return new EqualAngle($this->alfa, $this->beta)->compare();
    }
}