<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualAngle;
use Override;

/**
 * The strategy that compares two `AngularDistance` instances to check if the first is 
 * greater or equal than the last.
 * 
 * @internal
 */
class GreaterOrEqualAngularDistance extends GreaterOrEqualAngle
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularDistance $alfa The left comparison operand.
     * @param AngularDistance $beta The right comparison operand.
     */
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