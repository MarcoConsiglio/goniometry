<?php
namespace MarcoConsiglio\Goniometry\Comparisons\AngularDistance\Strategies;

use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Comparisons\Angle\Strategies\GreaterOrEqualString as AngleGreaterOrEqualString;
use Override;

/**
 * The strategy that compares an `AngularDistance` instance against a sexagesimal string 
 * measure of an angle to check if the first is greater or equal than the last.
 * 
 * @internal
 */
class GreaterOrEqualString extends AngleGreaterOrEqualString
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
        return 
            new EqualString($this->alfa, $this->beta)->compare() ||
            new GreaterString($this->alfa, $this->beta)->compare();
    }
}