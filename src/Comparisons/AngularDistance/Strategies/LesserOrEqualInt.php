<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualInt as AngleLesserOrEqualInt;
use Override;

/**
 * The strategy that compares an `AngularDistance` instance against a sexagesimal degrees 
 * measure of an angle to check if the first is lesser or equal than the last.
 * 
 * @internal
 */
class LesserOrEqualInt extends AngleLesserOrEqualInt
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularDistance $alfa The left comparison operand.
     * @param int $beta The right comparison operand.
     */
    public function __construct(AngularDistance $alfa, int $beta)
    {
        parent::__construct($alfa, $beta);
    }

    #[Override]
    public function compare(): bool
    {
        return 
            new EqualInt($this->alfa, $this->beta)->compare() ||
            new LesserInt($this->alfa, $this->beta)->compare();
    }
}