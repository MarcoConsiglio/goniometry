<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\LesserOrEqualString as AngleLesserOrEqualString;
use Override;

/**
 * The strategy that compares an `AngularDistance` instance against a sexagesimal string 
 * measure of an angle to check if the first is lesser or equal than the last.
 * 
 * @internal
 */
class LesserOrEqualString extends AngleLesserOrEqualString
{
    /**
     * Construct the comparison strategy.
     * 
     * @param AngularDistance $alfa The left comparison operand.
     * @param string $beta The right comparison operand.
     */
    public function __construct(AngularDistance $alfa, string $beta)
    {
        parent::__construct($alfa, $beta);
    }

    #[Override]
    public function compare(): bool
    {
        $beta = AngularDistance::createFromString($this->beta);
        return
            new EqualAngularDistance($this->alfa, $beta)->compare() ||
            new LesserAngularDistance($this->alfa, $beta)->compare();
    }
}